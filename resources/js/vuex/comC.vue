<template>
    <div>
        <h3>I am component C and the counter is {{this.lastTest}}</h3>
    </div>
</template>
<script>
import store from "../store";

export default {
    data() {
        return {
            test: store.state.counter
        }
    },
    computed: {
        lastTest() {
            return store.state.counter
        }
    },
}
</script>
