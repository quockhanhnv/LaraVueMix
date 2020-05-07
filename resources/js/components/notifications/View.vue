<template>
    <div class="customer-view" v-if="notification">
        <div class="user-img">
            <img src="https://www.scottsdaleazestateplanning.com/wp-content/uploads/2018/01/user.png" alt="">
        </div>
        <div class="user-info">
            <table class="table">
                <tr>
                    <th>ID</th>
                    <td>{{ notification.id }}</td>
                </tr>
                <tr>
                    <th>Name</th>
                    <td>{{ notification.notification_title }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ notification.notification_content }}</td>
                </tr>
                <tr>
                    <th>Author</th>
                    <td>{{ notification.author.name }}</td>
                </tr>
            </table>
            <router-link to="/notifications">Back to all notifications</router-link>
        </div>
    </div>
</template>

<script>
    export default {
        name: 'view',
        created() {
            if (this.notifications.length) {
                this.notification = this.notifications.find((notification) => notification.id == this.$route.params.id);
            } else {
                axios.get(`/api/notifications/${this.$route.params.id}`)
                    .then((response) => {
                        this.notification = response.data.notification
                    });
            }
        },
        data() {
            return {
                notification: null
            };
        },
        computed: {
            currentUser() {
                return this.$store.getters.currentUser;
            },
            notifications() {
                return this.$store.getters.notifications;
            }
        }
    }
</script>

<style scoped>
    .customer-view {
        display: flex;
        align-items: center;
    }
    .user-img {
        flex: 1;
    }
    .user-img img {
        max-width: 160px;
    }
    .user-info {
        flex: 3;
        overflow-x: scroll;
    }
</style>
