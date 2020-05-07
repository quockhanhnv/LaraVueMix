<template>
    <div>
        <div class="btn-wrapper">
            <router-link to="/notifications/new" class="btn btn-primary btn-sm">New</router-link>
        </div>
        <table class="table">
            <thead>
            <th>Title</th>
            <th>Content</th>
            <th>Author</th>
            <th>Actions</th>
            </thead>
            <tbody>
            <template v-if="!notifications.length">
                <tr>
                    <td colspan="4" class="text-center">No Notifications Available</td>
                </tr>
            </template>
            <template v-else>
                <tr v-for="notification in notifications" :key="notification.id">
                    <td>{{ notification.notification_title }}</td>
                    <td>{{ notification.notification_content }}</td>
                    <td>{{ notification.author.name }}</td>
                    <td>
                        <router-link :to="`/notifications/${notification.id}`">View</router-link>
                    </td>
                </tr>
            </template>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default {
        name: 'list',
        mounted() {
            if (this.notifications.length) {
                return;
            }

            this.$store.dispatch('getNotifications');
        },
        computed: {
            notifications() {
                return this.$store.getters.notifications;
            }
        }
    }
</script>

<style scoped>
    .btn-wrapper {
        text-align: right;
        margin-bottom: 20px;
    }
</style>
