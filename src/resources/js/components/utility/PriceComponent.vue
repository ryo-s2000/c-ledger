<template>
    <span v-if='price'>¥{{ price.toLocaleString() }}</span>
    <span v-else-if='price === 0'>¥0</span>
    <span v-else></span>
</template>

<script>
export default {
    props: {
        price: {
            type: Number,
            required: false
        }
    },
}
</script>
