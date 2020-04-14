<?php

namespace App\Services;

use App\Models\Album;
use App\Models\Artist;
use App\Models\Playlist;
use App\Models\Song;
use App\Models\SongZipArchive;
use Illuminate\Database\Eloquent\Collection;
use InvalidArgumentException;

class DownloadService
{
    /**
     * @var S3Service
     */
    private $s3Service;

    /**
     * @param S3Service $s3Service
     */
    public function __construct(S3Service $s3Service)
    {
        $this->s3Service = $s3Service;
    }

    /**
     * Generic method to generate a download archive from various source types.
     *
     * @param Song|Collection|Album|Artist|Playlist $mixed
     *
     * @throws InvalidArgumentException
     *
     * @return string Full path to the generated archive
     */
    public function from($mixed): string
    {
        switch (get_class($mixed)) {
            case Song::class:
                return $this->fromSong($mixed);
            case Collection::class:
                return $this->fromMultipleSongs($mixed);
            case Album::class:
                return $this->fromAlbum($mixed);
            case Artist::class:
                return $this->fromArtist($mixed);
            case Playlist::class:
                return $this->fromPlaylist($mixed);
        }

        throw new InvalidArgumentException('Unsupported download type.');
    }

    /**
     * @param Song $song
     * @return string
     */
    public function fromSong(Song $song): string
    {
        if ($s3Params = $song->s3_params) {
            // The song is hosted on Amazon S3.
            // We download it back to our local server first.
            $url = $this->s3Service->getSongPublicUrl($song);
            abort_unless($url, 404);

            $localPath = sys_get_temp_dir().DIRECTORY_SEPARATOR.basename($s3Params['key']);

            // The following function requires allow_url_fopen to be ON.
            // We're just assuming that to be the case here.
            copy($url, $localPath);
        } else {
            // The song is hosted locally. Make sure the file exists.
            $localPath = $song->path;
            abort_unless(file_exists($localPath), 404);
        }

        return $localPath;
    }

    /**
     * @param Collection $songs
     * @return string
     */
    protected function fromMultipleSongs(Collection $songs): string
    {
        if ($songs->count() === 1) {
            return $this->fromSong($songs->first());
        }

        return (new SongZipArchive())
            ->addSongs($songs)
            ->finish()
            ->getPath();
    }

    /**
     * @param Playlist $playlist
     * @return string
     */
    protected function fromPlaylist(Playlist $playlist): string
    {
        return $this->fromMultipleSongs($playlist->songs);
    }

    /**
     * @param Album $album
     * @return string
     */
    protected function fromAlbum(Album $album): string
    {
        return $this->fromMultipleSongs($album->songs);
    }

    /**
     * @param Artist $artist
     * @return string
     */
    protected function fromArtist(Artist $artist): string
    {
        return $this->fromMultipleSongs($artist->songs);
    }
}
