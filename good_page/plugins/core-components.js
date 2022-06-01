import Vue from 'vue'

import Card from "@/components/Card.vue";
import EditForm from '@/components/edit/EditForm.vue'
import CreateForm from "@/components/create-new/CreateForm.vue";
import CompleteForm from '@/components/complete/CompleteForm.vue';

Vue.component('Card',Card);
Vue.component('EditForm',EditForm);
Vue.component('CreateForm',CreateForm);
Vue.component('CompleteForm',CompleteForm);
