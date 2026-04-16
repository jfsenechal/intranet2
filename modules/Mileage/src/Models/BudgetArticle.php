<?php

declare(strict_types=1);

namespace AcMarche\Mileage\Models;

use AcMarche\Mileage\Database\Factories\BudgetArticleFactory;
use Illuminate\Database\Eloquent\Attributes\UseFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

#[UseFactory(BudgetArticleFactory::class)]
#[\Illuminate\Database\Eloquent\Attributes\Connection('maria-mileage')]
#[\Illuminate\Database\Eloquent\Attributes\Fillable([
    'name',
    'functional_code',
    'economic_code',
    'department',
])]
#[\Illuminate\Database\Eloquent\Attributes\Table(name: 'budget_articles')]
final class BudgetArticle extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * @return HasMany<Declaration>
     */
    public function declarations(): HasMany
    {
        return $this->hasMany(Declaration::class, 'article_budgetaire', 'nom');
    }

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
        ];
    }
}
