<div x-data="editor('<p>Hello world! :)</p>')">
    <template x-if="isLoaded()">
        <div>
            <button @click="toggleHeading({level: 1})"
                :class="{ 'is-active': isActive('heading', { level: 1 }, updatedAt) }">H1</button>
            <button @click="toggleBold()" :class="{ 'is-active': isActive('bold', updatedAt) }">Bold</button>
            <button @click="toggleItalic()" :class="{ 'is-active': isActive('italic', updatedAt) }">Italic</button>
        </div>
    </template>
    <div x-ref="element"></div>
</div>
