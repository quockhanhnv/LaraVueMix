<template>
    <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
        <div class="container">
            <router-link class="navbar-brand" to="/">{{ $t('logo') }}</router-link>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ml-auto">
                    <template>
                        <li><a href="#!" @click="setLocale('en')" class="nav-link">En</a></li>
                        <li><a href="#!" @click="setLocale('vn')" class="nav-link">Vn</a></li>
                        <li><a href="#!" @click="setLocale('jp')" class="nav-link">Jp</a></li>
                    </template>
                    <template v-if="!currentUser">
                        <li>
                            <router-link to="/login" class="nav-link">{{ $t('login') }}</router-link>
                        </li>
                        <li>
                            <router-link to="/register" class="nav-link">{{ $t('register') }}</router-link>
                        </li>
                    </template>
                    <template v-else>
                        <li>
                            <router-link to="/customers" class="nav-link">Customers</router-link>
                        </li>
                        <li>
                            <router-link to="/notifications" class="nav-link">Notification</router-link>
                        </li>

                        <li class="nav-item dropdown">
                            <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-expanded="false" aria-haspopup="true">
                                {{ currentUser.name }}  <span class="caret"></span>
                            </a>

                            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <a href="#!" @click.prevent="logout" class="dropdown-item">Logout</a>
                            </div>
                        </li>
<!--                        <p>{{ currentUser}}</p>-->
                    </template>
                </ul>
            </div>
        </div>
    </nav>
</template>

<script>
    export default {
        name: 'app-header',
        methods: {
            logout() {
                this.$store.commit('logout');
                this.$router.push('/login');
            },
            setLocale(locale) {
                import(`./langs/${locale}.json`).then((msgs) => {
                    this.$i18n.setLocaleMessage(locale, msgs)
                    this.$i18n.locale = locale
                })
            }
        },
        computed: {
            currentUser() {
                return this.$store.getters.currentUser
            }
        }
    }
</script>
