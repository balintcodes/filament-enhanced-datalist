@php
    $isDisabled = $isDisabled();
    $hasInlineLabel = $hasInlineLabel();
    $isConcealed = $isConcealed();
    $filterDatalist = $getFilterDatalist();
    $prefixActions = $getPrefixActions();
    $isPrefixInline = $isPrefixInline();
    $isSuffixInline = $isSuffixInline();
    $prefixIcon = $getPrefixIcon();
    $prefixLabel = $getPrefixLabel();
    $suffixActions = $getSuffixActions();
    $suffixIcon = $getSuffixIcon();
    $suffixLabel = $getSuffixLabel();

    $chevronStyle = "
        background-image: url(\"data:image/svg+xml;charset=utf-8,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3E%3Cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='m6 8 4 4 4-4'/%3E%3C/svg%3E\");
        background-position: right .5rem center;
        background-repeat: no-repeat;
        background-size: 1.5rem 1.5rem;
        padding-right: 2.5rem;
        -webkit-print-color-adjust: exact;
        print-color-adjust: exact;
    ";
@endphp

<x-dynamic-component
    :component="$getFieldWrapperView()"
    :field="$field"
    x-data="{ value: '{{ $getState() }}', showDatalist: false, highlightedValue: null }"
    x-on:click.outside="showDatalist = false"
>

    <x-filament::input.wrapper
        :disabled="$isDisabled"
        :inline-prefix="$isPrefixInline"
        :inline-suffix="$isSuffixInline"
        :prefix="$prefixLabel"
        :prefix-actions="$prefixActions"
        :prefix-icon="$prefixIcon"
        :prefix-icon-color="$getPrefixIconColor()"
        :suffix="$suffixLabel"
        :suffix-actions="$suffixActions"
        :suffix-icon="$suffixIcon"
        :suffix-icon-color="$getSuffixIconColor()"
        :attributes="
            \Filament\Support\prepare_inherited_attributes($getExtraAttributeBag())
                ->class(['fi-fo-text-input overflow-hidden'])
        "
        style="overflow: visible !important;"
        x-on:click="showDatalist = !showDatalist; $nextTick(() => { $refs.input.focus() });"
        class="relative"
    >
        <x-filament::input
            :attributes="
                \Filament\Support\prepare_inherited_attributes($getExtraInputAttributeBag())
                    ->merge($getExtraAlpineAttributes(), escape: false)
                    ->merge([
                        'maxlength' => (! $isConcealed) ? $getMaxLength() : null,
                        'minlength' => (! $isConcealed) ? $getMinLength() : null,
                        'readonly' => $isReadOnly(),
                        'placeholder' => $getPlaceholder(),
                        'disabled' => $isDisabled,
                        'id' => $getId(),
                        'required' => $isRequired() && (! $isConcealed),
                        'inlinePrefix' => $isPrefixInline && (count($prefixActions) || $prefixIcon || filled($prefixLabel)),
                        'inlineSuffix' => $isSuffixInline && (count($suffixActions) || $suffixIcon || filled($suffixLabel)),
                        $applyStateBindingModifiers('wire:model') => $getStatePath()
                    ], escape: false)
            "
            x-ref="input"
            x-model="value"
            x-on:wire:click="showDatalist = true"
            x-on:keyup="showDatalist = true"
            autocomplete="off"
            role="combobox"
            aria-autocomplete="list"
            x-bind:aria-expanded="showDatalist.toString()"
            aria-controls="{{ $getId() }}-datalist"
            x-bind:aria-activedescendant="highlightedValue ?? ''"
            style="{{ $isChevronVisible() ? $chevronStyle : '' }}"
        >
        </x-filament::input>

        <div
            class="choices__list choices__list--dropdown absolute"
            x-bind:class="showDatalist ? 'is-active' : ''"
            id="{{ $getId() }}-datalist"
            style="left: 0;"
        >
            <div
                class="choices__list text-lg sm:text-sm"
                role="listbox"
                aria-labelledby="{{ $getId() }}"
            >
                <div
                    class="choices__item choices__item--choice choices__item--disabled">{{ __('filament-free-text-select::free-text-select.info') }}</div>
                @foreach($getOptions() as $key => $option)
                    <div
                        x-data="{ hovered: false }"
                        x-on:mouseenter="hovered = true; highlightedValue = '{{ $option }}'"
                        x-on:mouseleave="hovered = false; highlightedValue = null"
                        class="choices__item choices__item--choice choices__item--selectable"
                        x-bind:class="hovered ? 'is-highlighted' : ''"
                        @if($filterDatalist)
                            x-show="value === '' || '{{ $option }}'.toLowerCase().includes(value.toLowerCase())"
                        @endif
                        x-on:click.stop="value = '{{ $option }}'; showDatalist = false"
                        role="option"
                        x-bind:aria-selected="hovered"
                    >{{ $option }}</div>
                @endforeach
            </div>
        </div>

    </x-filament::input.wrapper>

</x-dynamic-component>

