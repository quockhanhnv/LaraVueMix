<template>
    <div class="login row justify-content-center">
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">
                    {{ $t('login') }}
                </div>
                <div class="card-body">
                    <form @submit.prevent="authenticate">
                        <div class="form-group row">
                            <label for="email">Email</label>
                            <input type="text" v-model="form.email" class="form-control" placeholder="Email Address" id="email">
                        </div>
                        <div class="form-group row">
                            <label for="password">{{ $t('password') }}</label>
                            <input type="password" v-model="form.password" class="form-control" placeholder="Password" id="password">
                        </div>
                        <div class="form-group row">
<!--                            <input type="submit" value="$t('login')">-->
                            <button type="submit">{{ $t('login') }}</button>
                        </div>

                        <div class="form-group row" v-if="authError">
                            <p class="error">
                                {{ authError }}
                            </p>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>


<script>
    import {login} from '../../helpers/auth.js'
    export default {
        name: "login",
        data() {
            return {
                form: {
                    email: '',
                    password: ''
                },
                error: null
            }
        },
        methods: {
            authenticate() {
                this.$store.dispatch('login') // dispatch to action of store (2 ways to commit or dispatch => line 54)

                // login form auth.js
                login(this.$data.form).then((res) => {
                    this.$store.commit('loginSuccess', res); // commit to mutations of store (2 ways to commit or dispatch line 50)
                    this.$router.push({path: '/'})
                }).catch((error) => {
                    this.$store.commit('loginFailed', {error});
                })
            }
        },
        computed: {
            authError() {
                return this.$store.getters.authError
            }
        }
    }
</script>

<style scoped>
    .error {
        text-align: center;
        color: red;
    }
</style>
