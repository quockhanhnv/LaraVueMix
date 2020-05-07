<template>
    <div class="notification-new">
        <form @submit.prevent="add">
            <table class="table">
                <tr>
                    <th>Title</th>
                    <td>
                        <input type="text" class="form-control" v-model="notification.notification_title" placeholder="Notification Name"/>
                    </td>
                </tr>
                <tr>
                    <th>Content</th>
                    <td>
                        <input type="text" class="form-control" v-model="notification.notification_content" placeholder="Notification Content"/>
                    </td>
                </tr>
                <tr>
                    <td>
                        <router-link to="/notifications" class="btn">Cancel</router-link>
                    </td>
                    <td class="text-right">
                        <input type="submit" value="Create" class="btn btn-primary">
                    </td>
                </tr>
            </table>
            {{notification}}
        </form>
        <div class="errors" v-if="errors">
            <ul>
                <li v-for="(fieldsError, fieldName) in errors" :key="fieldName">
                    <strong>{{ fieldName }}</strong> {{ fieldsError.join('\n') }}
                </li>
            </ul>
        </div>
    </div>
</template>

<script>

    import validate from 'validate.js';
    export default {
        name: 'new',
        data() {
            return {
                notification: {
                    notification_title: '',
                    notification_content: '',
                },
                errors: null
            };
        },
        computed: {
            currentUser() {
                return this.$store.getters.currentUser;
            }
        },
        methods: {
            add() {
                this.errors = null;
                const constraints = this.getConstraints();
                const errors = validate(this.$data.notification, constraints);
                if(errors) {
                    this.errors = errors;
                    return;
                }
                axios.post('/api/notifications/new', this.$data.notification)
                    .then((response) => {
                        console.log(response)
                        this.$router.push('/notifications');
                    });
            },
            getConstraints() {
                return {
                    notification_title: {
                        presence: true,
                        length: {
                            minimum: 3,
                            message: 'Must be at least 3 characters long'
                        }
                    },
                    notification_content: {
                        presence: true,
                        length: {
                            minimum: 3,
                            message: 'Must be at least 3 characters long'
                        }
                    },

                };
            }
        }
    }
</script>

<style>
    .errors {
        background: lightcoral;
        border-radius:5px;
        padding: 21px 0 2px 0;
    }
</style>
