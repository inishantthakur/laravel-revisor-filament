<?php

declare(strict_types=1);

namespace Indra\RevisorFilament\Tests\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Indra\Revisor\Concerns\HasRevisor;
use Indra\Revisor\Contracts\HasRevisor as HasRevisorContract;
use Indra\RevisorFilament\Tests\Database\Factories\PageFactory;

class Page extends Model implements HasRevisorContract
{
    use HasFactory;
    use HasRevisor;

    protected string $baseTable = 'pages';

    protected $fillable = [
        'title',
    ];

    protected static function newFactory()
    {
        return PageFactory::new();
    }
}
