<?php

namespace Balintxd\FilamentEnhancedDatalist;

use Closure;
use Filament\Forms\Components\Concerns\CanBeLengthConstrained;
use Filament\Forms\Components\Concerns\CanBeReadOnly;
use Filament\Forms\Components\Concerns\HasAffixes;
use Filament\Forms\Components\Concerns\HasExtraInputAttributes;
use Filament\Forms\Components\Concerns\HasOptions;
use Filament\Forms\Components\Concerns\HasPlaceholder;
use Filament\Forms\Components\Contracts\HasAffixActions;
use Filament\Forms\Components\Field;
use Filament\Support\Concerns\HasExtraAlpineAttributes;

class FilamentEnhancedDatalist extends Field implements \Filament\Forms\Components\Contracts\CanBeLengthConstrained, HasAffixActions
{
    use CanBeLengthConstrained;
    use CanBeReadOnly;
    use HasAffixes;
    use HasExtraAlpineAttributes;
    use HasExtraInputAttributes;
    use HasOptions;
    use HasPlaceholder;

    protected string $view = 'filament-enhanced-datalist::filament-enhanced-datalist';

    protected bool|Closure $filterDatalist = true;

    protected bool|Closure $chevronVisible = true;

    protected string|null $infoLabel = null;

    public function filterDatalist(bool|Closure $condition = true): static
    {
        $this->filterDatalist = $condition;

        return $this;
    }

    public function getFilterDatalist(): bool
    {
        return (bool)$this->evaluate($this->filterDatalist);
    }

    public function chevronVisible(bool|Closure $condition = true): static
    {
        $this->chevronVisible = $condition;

        return $this;
    }

    public function isChevronVisible(): bool
    {
        return (bool)$this->evaluate($this->chevronVisible);
    }

    public function infoLabel(string|null|false $infoLabel = null): static
    {
        $this->infoLabel = $infoLabel;

        return $this;
    }

    public function getInfoLabel(): string|null
    {
        return $this->infoLabel;
    }

    protected function setUp(): void
    {
        parent::setUp();
    }
}
