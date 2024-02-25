<template>
    <div>
        <div class="content">
            <div class="container-fluid">
                <h3>I will show how all other components are changed</h3>
                <h2>Current state of count is {{getCounter}}</h2>
                <span>{{this.lastTest}}</span>
                <div>
                    <comA />
                </div><div>
                    <comB />
                </div><div>
                    <comC />
                </div>

                <Button @click="changeCounter"> Change the state</Button>
                <Button @click="changeWithAction"> Change with Action</Button>
            </div>
        </div>

    </div>
</template>
<script>
    import store from "../store";
    import comA from './comA.vue'
    import comB from './comB.vue'
    import comC from './comC.vue'
    import { mapGetters } from "vuex";

    export default {
        data() {
            return {
                test: store.state.counter
            }
        },
        methods: {
            changeCounter() {
                store.commit('changeTheCounter', 1)
            },
            changeWithAction() {
                store.dispatch('changeCounterAction', 1)
            }
        },
        created() {
            this.test = store.state.counter
            console.log(this.lastTest)
        },
        computed: {
          lastTest() {
              return store.state.counter
          },
          getCounter() {
              return store.getters.getCounter
          }
        },
        components: {
            comA,
            comB,
            comC,
        }
    }
</script>
