<template>
    <div>
        <div>
            <!--========== ADMIN SIDE MENU one ========-->
            <div v-if="this.getUser()" class="_1side_menu">
                <div class="_1side_menu_logo">
                    <h3 style="text-align:center;">Logo Image</h3>
                    <!--<img src="/img/logo.jpg" style="width: 108px;margin-left: 68px;"/>-->
                </div>

                <!--~~~~~~~~ MENU CONTENT ~~~~~~~~-->
                <div class="_1side_menu_content">
                    <div class="_1side_menu_img_name">
                        <!-- <img class="_1side_menu_img" src="/pic.png" alt="" title=""> -->
                        <p class="_1side_menu_name">Admin</p>
                    </div>

                    <!--~~~ MENU LIST ~~~~~~-->
                    <div class="_1side_menu_list">
                        <ul class="_1side_menu_list_ul">
                            <li><router-link to="/"><Icon type="ios-speedometer" /> Dashboard</router-link></li>
                            <li><router-link to="/tags"><Icon type="ios-speedometer" /> Tags</router-link></li>
                            <li><router-link to="/category"><Icon type="ios-speedometer" /> Category</router-link></li>
                            <li><router-link to="/adminusers"><Icon type="ios-speedometer" /> Admin users</router-link></li>
                            <li><router-link to="/role"><Icon type="ios-speedometer" /> Role Management</router-link></li>
                            <li><router-link to="/assign-role"><Icon type="ios-speedometer" /> Assign Role</router-link></li>
                            <li><a href="/logout"><Icon type="ios-speedometer" /> LogOut</a></li>

                        </ul>
                    </div>
                </div>
            </div>
            <div v-else-if="!this.getUser()">
                <div class="_1side_menu_list">
                    <ul class="_1side_menu_list_ul">

                        <li><router-link to="/login"><Icon type="ios-speedometer" /> Login</router-link></li>

                    </ul>
                </div>

            </div>
            <!--========== ADMIN SIDE MENU ========-->

            <!--========= HEADER ==========-->
            <div class="header">
                <div class="_2menu _box_shadow">
                    <div class="_2menu_logo">
                        <ul class="open_button">
                            <li>
                                <Icon type="ios-list" />
                            </li>
                            <!--<li><Icon type="ios-albums" /></li>-->
                        </ul>
                    </div>
                </div>
            </div>
            <router-view/>
        </div>
    </div>
</template>
<script>
    import store from "./store";
    export default {
        props: ['user'],
        data() {
            return {
                isLoggedIn: false,
            }
        },
        mounted() {
            console.log('Component mounted.')
        },
        created() {
            store.commit('updateUser', this.user)
        },
        methods: {
            getUser() {
                return store.getters.getUser
            }
        }
    }
</script>
