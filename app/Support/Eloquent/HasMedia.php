<?php

namespace App\Support\Eloquent;

use App\Models\File;
use Illuminate\Database\Eloquent\Relations\MorphToMany;

/**
 * @method static saved(\Closure $param)
 * @method morphToMany(string $class, string $string, string $string1)
 */
trait HasMedia
{
    /**
     * The "booting" method of the trait.
     *
     * @return void
     */
    public static function bootHasMedia(): void
    {
        static::saved(static function ($entity) {
            $entity->syncFiles(request('files', []));
        });
    }

    /**
     * Get all the files for the entity.
     *
     * @return MorphToMany
     */
    public function files(): MorphToMany
    {
        return $this->morphToMany(File::class, 'entity', 'entity_files')
            ->withPivot(['id', 'zone'])
            ->withTimestamps();
    }

    /**
     * Filter files by zone.
     *
     * @param string $zone
     * @return MorphToMany
     */
    public function filterFiles(string $zone): MorphToMany
    {
        return $this->files()->wherePivot('zone', $zone);
    }

    /**
     * Sync files for the entity.
     *
     * @param array $files
     */
    public function syncFiles(array $files = []): void
    {
        $entityType = get_class($this);

        foreach ($files as $zone => $fileIds) {
            $syncList = [];

            foreach (array_wrap($fileIds) as $fileId) {
                if (! empty($fileId)) {
                    $syncList[$fileId]['zone'] = $zone;
                    $syncList[$fileId]['entity_type'] = $entityType;
                }
            }

            $this->filterFiles($zone)->detach();
            $this->filterFiles($zone)->attach($syncList);
        }
    }
}
