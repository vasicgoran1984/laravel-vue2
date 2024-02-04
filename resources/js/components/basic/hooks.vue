<template>
    <div>
        <h2 ref="myref">Hooks</h2>
        <p>My name is: {{name}}</p>
    </div>
</template>

<script>
export default {
    data() {
        return {
            name: 'Goran',
        }
    },

    beforeCreate() {
       console.log(this.name)
    },

    created() {
        // call mostly initial data from it...
        console.log('data and other function is available but not html', this.name)
    },

    // instantiated after render all page
    mounted() {
        console.log(this.$refs.myref)
    }
}
</script>
