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
    $optionsJson = json_encode($options, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_AMP | JSON_HEX_QUOT);
    $isReadOnly = $isReadOnly();

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
    x-data="{
        value: '{{ $getState() }}',
        showDatalist: false,
        highlightedValue: null,
        highlightedIndex: null,
        opts: {!! $optionsJson !!},
        keys: Object.keys({!! $optionsJson !!}).map(String),
        readOnly: {{ $isReadOnly ? 'true' : 'false' }},
        toggleDatalist(show) {
            if (!this.readOnly) this.showDatalist = show;
        },
        setValue(val) {
            if (!this.readOnly) this.value = val;
        },
        getNextIndex(currKey) {
            if (currKey === null || currKey === undefined) return this.keys[0];
            const pos = this.keys.indexOf(currKey);
            return this.keys[(pos + 1) % this.keys.length];
        },
        getPrevIndex(currKey) {
            if (currKey === null || currKey === undefined) return this.keys[this.keys.length - 1];
            const pos = this.keys.indexOf(currKey);
            return this.keys[(pos - 1 + this.keys.length) % this.keys.length];
        },
        getHighlightedValue(currKey) {
            return this.opts[currKey];
        }
    }"
    x-on:click.outside="toggleDatalist(false)"
    x-on:keydown.esc="toggleDatalist(false)"
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
        class="fi-enhanced-datalist-wrap relative"
        style="overflow: visible !important;"
    >
        <x-filament::input
            :attributes="
                \Filament\Support\prepare_inherited_attributes($getExtraInputAttributeBag())
                    ->merge($getExtraAlpineAttributes(), escape: false)
                    ->merge([
                        'maxlength' => (! $isConcealed) ? $getMaxLength() : null,
                        'minlength' => (! $isConcealed) ? $getMinLength() : null,
                        'readonly' => $isReadOnly,
                        'placeholder' => $getPlaceholder(),
                        'disabled' => $isDisabled,
                        'id' => $id,
                        'required' => $isRequired() && (! $isConcealed),
                        'inlinePrefix' => $isPrefixInline && (count($prefixActions) || $prefixIcon || filled($prefixLabel)),
                        'inlineSuffix' => $isSuffixInline && (count($suffixActions) || $suffixIcon || filled($suffixLabel)),
                        $applyStateBindingModifiers('wire:model') => $getStatePath()
                    ], escape: false)
            "
            style="{{ $isChevronVisible() && !$isReadOnly ? $chevronStyle : '' }}"
            autocomplete="off"
            role="combobox"
            aria-autocomplete="list"
            aria-controls="{{ $id }}-datalist"
            x-model="value"
            x-on:click="toggleDatalist(true)"
            x-on:keydown="toggleDatalist(true)"
            x-on:keyup.down="highlightedIndex = getNextIndex(highlightedIndex)"
            x-on:keyup.up="highlightedIndex = getPrevIndex(highlightedIndex)"
            x-on:keydown.prevent.enter="setValue(getHighlightedValue(highlightedIndex)); toggleDatalist(false);"
            x-on:blur="toggleDatalist(false)"
            x-bind:aria-expanded="showDatalist.toString()"
            x-bind:aria-activedescendant="highlightedValue ?? ''"
        >
        </x-filament::input>

        <div
            class="fi-dropdown-panel fi-scrollable fi-enhanced-datalist"
            id="{{ $id }}-datalist"
            role="listbox"
            x-show="showDatalist"
            x-cloak
            x-on:mousedown.prevent
        >
            <div
                class="fi-dropdown-list text-lg sm:text-sm"
                role="listbox"
                aria-labelledby="{{ $id }}"
            >
                <div class="fi-dropdown-list-item fi-select-input-option" disabled>
                    @if($infoLabel === null)
                        {{ __('filament-enhanced-datalist::enhanced-datalist.info') }}
                    @else
                        {{ $infoLabel }}
                    @endif
                </div>
                @foreach($options as $key => $option)
                    <div
                        class="fi-dropdown-list-item fi-select-input-option"
                        role="option"
                        tabindex="0"
                        x-on:mouseenter="highlightedValue = '{{ $option }}'; highlightedIndex = '{{ $key }}';"
                        x-on:mouseleave="highlightedValue = null; highlightedIndex = null;"
                        x-bind:class="'{{ $key }}' === String(highlightedIndex) ? 'is-highlighted' : ''"
                        @if($filterDatalist)
                            x-show="value === '' || '{{ $option }}'.toLowerCase().includes(value.toLowerCase())"
                        @endif
                        x-on:click.stop="value = '{{ $option }}'; toggleDatalist(false); $wire.$set('{{ $getStatePath(true) }}', '{{ $option }}');"
                        x-bind:aria-selected="'{{ $key }}' === String(highlightedIndex)"
                    >{{ $option }}</div>
                @endforeach
            </div>
        </div>

    </x-filament::input.wrapper>

</x-dynamic-component>
