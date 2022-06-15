<?php

namespace App\Modules\Delivery\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

/**
 * Modules\Delivery\Models\Transportation
 *
 * @property int $id
 * @property string $name
 * @property string $company_name
 * @property string $url
 * @property int $type
 * @property int $price
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @method static Builder|Transportation whereType($type)
 */

class Transportation extends Model
{
    protected $table = 'transportation';
}
