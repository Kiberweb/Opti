<script setup>
import { computed } from 'vue';

const version = '0.0.3';
const emit = defineEmits(['update:selected']);

const props = defineProps({
    inObject: {
        type: Object,
        default: {
            value: null,
            label: null,
        },
    },
    selected: {
        type: Number,
        default: null,
    },
    value: {
        default: null,
    },
    options: {
        type: Array,
        default: [],
    },
    myClasses: {
        type: String,
        default: 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500',
    },
});

// When value is array get string and when value is object get undefined
const isObject = typeof props.options[0] !== 'string';

function element(value, item) {
    if (isObject === undefined && item !== undefined) {
        return value[props.inObject[item]];
    }

    return value;
}
//Object.prototype.toString.call(props.options[0]); // [object Object]

const proxySelected = computed({
    get() {
        return props.selected;
    },
    set(val) {
        emit('update:selected', val);
    }
});
</script>

<template>
    <select v-model="proxySelected" :class="myClasses + ' shadow-sm'">
        <option v-for="item in props.options" :key="element(item, 'value')" :value="element(item, 'value')" :selected="element(item, 'value') === props.selected">
            {{ element(item, 'label') }}
        </option>
    </select>
</template>

<style scoped>

</style>
