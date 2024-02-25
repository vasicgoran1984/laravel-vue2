<template>
    <div>
        <template>
            <div>
                <div class="content">

                    <div class="container-fluid">
                        <div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20 col-md-4">
                            <div class="login_header">
                                <h2>Login</h2>
                            </div>
                            <div class="space">
                                <Input v-model="data.email" type="email" placeholder="Email" />
                            </div>
                            <div class="space">
                                <Input v-model="data.password" type="password" placeholder="Password" />
                            </div>
                            <div class="login_footer">
                                <Button @click="login" type="primary" :disabled="isLogging" :loading="isLogging">{{isLogging ? 'Loging...' : 'Login'}}</Button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>


    </div>
</template>

<style scoped>
._1adminOverveiw_table_recent {
    margin: 0 auto;
    margin-top: 120px;
}
.login_header {
    text-align: center;
    margin-bottom: 10px;
}
.login_footer {
    text-align: center;
}
</style>

<script>
import store from '../../store'
export default {
    data() {
        return {
            data: {
                email: '',
                password: '',
            },
            isLogging: false,
            user: '',
        }
    },
    methods: {
        async login() {
            if(this.data.email.trim() == '') return this.e('Email is required!')
            if(this.data.password.trim() == '') return this.e('Password is required!')
            if(this.data.password.length < 6) return this.e('Incorrect login details!')

            this.isLogging = true

            const res = await this.callApi('post', 'app/admin_login', this.data)

            if (res.status === 200) {
                window.location = '/'
                this.s(res.data.msg)
            } else if (res.status === 422) {
                for (let i in res.data.errors) {
                    this.e(res.data.errors[i][0])
                }
            } else {
                if (res.status === 401) {
                    this.i(res.data.msg)
                } else {
                    this.swr()
                }
            }
            this.isLogging = false
        }
    },
}
</script>
