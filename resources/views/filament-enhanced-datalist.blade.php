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
    $infoLabel = $getInfoLabel();
    $id = $getId();
    $options = $getOptions();

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
    x-data="{ value: '{{ $getState() }}', showDatalist: false, highlightedValue: null, highlightedIndex: null }"
    x-on:click.outside="showDatalist = false"
    x-on:keydown.esc="showDatalist = false"
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
        class="relative"
        style="overflow: visible !important;"
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
                        'id' => $id,
                        'required' => $isRequired() && (! $isConcealed),
                        'inlinePrefix' => $isPrefixInline && (count($prefixActions) || $prefixIcon || filled($prefixLabel)),
                        'inlineSuffix' => $isSuffixInline && (count($suffixActions) || $suffixIcon || filled($suffixLabel)),
                        $applyStateBindingModifiers('wire:model') => $getStatePath()
                    ], escape: false)
            "
            style="{{ $isChevronVisible() ? $chevronStyle : '' }}"
            autocomplete="off"
            role="combobox"
            aria-autocomplete="list"
            aria-controls="{{ $id }}-datalist"
            x-model="value"
            x-data="datalistNavigation()"
            x-on:click="showDatalist = true"
            x-on:keydown="showDatalist = true;"
            x-on:keyup.down="highlightedIndex = getNextIndex(highlightedIndex)"
            x-on:keyup.up="highlightedIndex = getPrevIndex(highlightedIndex)"
            x-on:keydown.prevent.enter="value = getHighlightedValue(highlightedIndex); showDatalist = false;"
            x-on:blur="showDatalist = false"
            x-bind:aria-expanded="showDatalist.toString()"
            x-bind:aria-activedescendant="highlightedValue ?? ''"
        >
        </x-filament::input>

        <div
            class="choices__list choices__list--dropdown absolute"
            id="{{ $id }}-datalist"
            style="left: 0;"
            x-bind:class="showDatalist ? 'is-active' : ''"
            x-on:mousedown.prevent
        >
            <div
                class="choices__list text-lg sm:text-sm"
                role="listbox"
                aria-labelledby="{{ $id }}"
            >
                <div class="choices__item choices__item--choice choices__item--disabled">
                    @if($infoLabel === null)
                        {{ __('filament-enhanced-datalist::enhanced-datalist.info') }}
                    @else
                        {{ $infoLabel }}
                    @endif
                </div>
                @foreach($options as $key => $option)
                    <div
                        class="choices__item choices__item--choice choices__item--selectable"
                        role="option"
                        x-on:mouseenter="highlightedValue = '{{ $option }}'; highlightedIndex = '{{ $key }}';"
                        x-on:mouseleave="highlightedValue = null; highlightedIndex = null;"
                        x-bind:class="'{{ $key }}' === String(highlightedIndex) ? 'is-highlighted' : ''"
                        @if($filterDatalist)
                            x-show="value === '' || '{{ $option }}'.toLowerCase().includes(value.toLowerCase())"
                        @endif
                        x-on:click.stop="value = '{{ $option }}'; showDatalist = false"
                        x-bind:aria-selected="'{{ $key }}' === String(highlightedIndex)"
                    >{{ $option }}</div>
                @endforeach
            </div>
        </div>

    </x-filament::input.wrapper>

</x-dynamic-component>

@once
    <script>
        function datalistNavigation() {
            const opts = @json($options, JSON_THROW_ON_ERROR);
            const keys = Object.keys(opts).map(String);
            return {
                getNextIndex(currKey) {
                    if (currKey === null || currKey === undefined) {
                        return keys[0];
                    }
                    const currKeyPos = keys.indexOf(currKey);
                    const nextKeyPos = (currKeyPos + 1) % keys.length;
                    return keys[nextKeyPos];
                },
                getPrevIndex(currKey) {
                    if (currKey === null || currKey === undefined) {
                        return keys[keys.length - 1];
                    }
                    const currKeyPos = keys.indexOf(currKey);
                    const prevKeyPos = (currKeyPos - 1 + keys.length) % keys.length;
                    return keys[prevKeyPos];
                },
                getHighlightedValue(currKey) {
                    const currKeyPos = keys.indexOf(currKey);
                    return opts[keys[currKeyPos]];
                }
            };
        }
    </script>
@endonce
