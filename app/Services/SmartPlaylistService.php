<?php

namespace App\Services;

use App\Models\Playlist;
use App\Models\Rule;
use App\Models\Song;
use App\Models\User;
use App\Repositories\SongRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use RuntimeException;

class SmartPlaylistService
{
    private const RULE_REQUIRES_USER_PREFIXES = ['interactions.'];

    /**
     * @var SongRepository
     */
    private $songRepository;

    /**
     * @param SongRepository $songRepository
     */
    public function __construct(SongRepository $songRepository)
    {
        $this->songRepository = $songRepository;
    }

    /**
     * @param Playlist $playlist
     * @return Collection
     */
    public function getSongs(Playlist $playlist): Collection
    {
        if (!$playlist->is_smart) {
            throw new RuntimeException($playlist->name.' is not a smart playlist.');
        }

        $rules = $this->addRequiresUserRules($playlist->rules, $playlist->user);

        return $this->buildQueryFromRules($rules)->get();
    }

    /**
     * @param array $rules
     * @return Builder
     */
    public function buildQueryFromRules(array $rules): Builder
    {
        $query = Song::query();

        collect($rules)->each(static function (array $ruleGroup) use ($query): void {
            $query->orWhere(static function (Builder $subQuery) use ($ruleGroup): void {
                foreach ($ruleGroup['rules'] as $config) {
                    Rule::create($config)->build($subQuery);
                }
            });
        });

        return $query;
    }

    /**
     * Some rules need to be driven by an additional "user" factor, for example play count, liked, or last played
     * (basically everything related to interactions).
     * For those, we create an additional "user_id" rule.
     *
     * @param array[] $rules
     * @param User $user
     * @return array
     */
    public function addRequiresUserRules(array $rules, User $user): array
    {
        foreach ($rules as &$ruleGroup) {
            $additionalRules = [];

            foreach ($ruleGroup['rules'] as &$config) {
                foreach (self::RULE_REQUIRES_USER_PREFIXES as $modelPrefix) {
                    if (starts_with($config['model'], $modelPrefix)) {
                        $additionalRules[] = $this->createRequireUserRule($user, $modelPrefix);
                    }
                }
            }

            // make sure all those additional rules are unique.
            $ruleGroup['rules'] = array_merge($ruleGroup['rules'], collect($additionalRules)->unique('model')->all());
        }

        return $rules;
    }

    /**
     * @param User $user
     * @param string $modelPrefix
     * @return array
     */
    private function createRequireUserRule(User $user, string $modelPrefix): array
    {
        return [
            'model' => $modelPrefix.'user_id',
            'operator' => 'is',
            'value' => [$user->id],
        ];
    }
}
