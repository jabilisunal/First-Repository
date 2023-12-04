<?php

namespace App\Models;

use App\Media\IconResolver;
use Closure;
use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;

/**
 * App\Models\File
 *
 * @property mixed $disk
 * @property mixed $mime
 * @method static create(array $array)
 * @method static find(int $id)
 * @method static when(mixed $get, Closure $param)
 * @property int $id
 * @property string $filename
 * @property string $path
 * @property string $extension
 * @property string $size
 * @property Carbon $created_at
 * @property Carbon|null $updated_at
 * @property Carbon|null $deleted_at
 * @method static Builder|File newModelQuery()
 * @method static Builder|File newQuery()
 * @method static Builder|File onlyTrashed()
 * @method static Builder|File query()
 * @method static Builder|File whereCreatedAt($value)
 * @method static Builder|File whereDeletedAt($value)
 * @method static Builder|File whereDisk($value)
 * @method static Builder|File whereExtension($value)
 * @method static Builder|File whereFilename($value)
 * @method static Builder|File whereId($value)
 * @method static Builder|File whereMime($value)
 * @method static Builder|File wherePath($value)
 * @method static Builder|File whereSize($value)
 * @method static Builder|File whereUpdatedAt($value)
 * @method static Builder|File withTrashed()
 * @method static Builder|File withoutTrashed()
 * @method static makeDirectory(string $filepath)
 * @mixin Eloquent
 */
class File extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * @var string $connection
     */
    protected $connection = 'mysql';

    /**
     * @var string $table
     */
    protected $table = 'files';

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array $fillable
     */
    protected $fillable = [
        'id',
        'filename',
        'disk',
        'path',
        'extension',
        'mime',
        'size'
    ];

    /**
     * The attributes that should be visible in serialization.
     *
     * @var array
     */
    protected $visible = ['id', 'filename', 'path'];

    /**
     * Perform any actions required after the model boots.
     *
     * @return void
     */
    protected static function booted(): void
    {
        static::deleting(static function ($file) {
            Storage::disk($file->disk)->delete($file->getRawOriginal('path'));
        });
    }

    /**
     * Get file's real path.
     *
     * @return ?string
     */
    public function realPath(): ?string
    {
        if (!is_null($this->attributes['path'])) {
            return Storage::disk($this->disk)->path($this->attributes['path']);
        }

        return null;
    }

    /**
     * Determine if the file type is image.
     *
     * @return bool
     */
    public function isImage(): bool
    {
        return strtok($this->mime, '/') === 'image';
    }

    /**
     * Get the file's icon.
     *
     * @return string
     */
    public function icon(): string
    {
        return IconResolver::resolve($this->mime);
    }
}
