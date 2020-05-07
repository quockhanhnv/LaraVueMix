<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card card-default">
                    <div class="card-header">Laravel VueJs Training Project At Fabbi</div>

                    <div class="card-body">
                        <h2>{{ welcome }}</h2>
                        <img src="http://theme.hstatic.net/1000218340/1000279691/14/image_header_logo.png?v=555" alt="WeCode">
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'home',
        computed: { // fetch data from store
            welcome() {
                return this.$store.getters.welcome
            }
        }
    }
</script>
