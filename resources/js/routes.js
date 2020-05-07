import Home from './components/Home.vue';
import Login from './components/auth/Login.vue';
import CustomersMain from './components/customers/Main.vue';
import CustomersList from './components/customers/List.vue';
import NewCustomer from './components/customers/New.vue';
import Customer from './components/customers/View.vue';

import NotificationsMain from './components/notifications/Main.vue';
import NotificationsList from './components/notifications/List.vue';
import NewNotification from './components/notifications/New.vue';
import Notification from './components/notifications/View.vue';

export const routes = [
    {
        path: '/',
        component: Home,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/login',
        component: Login
    },
    {
        path: '/customers',
        component: CustomersMain,
        meta: {
            requiresAuth: true
        },
        children: [
            {
                path: '/',
                component: CustomersList
            },
            {
                path: 'new',
                component: NewCustomer
            },
            {
                path: ':id',
                component: Customer
            }
        ]
    },
    {
        path: '/notifications',
        component: NotificationsMain,
        meta: {
            requiresAuth: true
        },
        children: [
            {
                path: '/',
                component: NotificationsList
            },
            {
                path: 'new',
                component: NewNotification
            },
            {
                path: ':id',
                component: Notification
            }
        ]
    }
];
