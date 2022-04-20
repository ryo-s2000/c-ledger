<template>
    <a target="_blank" rel="noopener noreferrer" :href="url">{{ text }}</a>
</template>

<script>
export default {
    props: {
        text: {
            type: String,
            required: true
        },
        url: {
            type: String,
            required: true
        },
    },
}
</script>
