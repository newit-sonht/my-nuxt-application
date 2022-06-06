import Vue from 'vue'

import Card from "@/components/Card.vue";
import EditForm from '@/components/edit/EditForm.vue'
import CreateForm from "@/components/create-new/CreateForm.vue";
import CompleteForm from '@/components/complete/CompleteForm.vue';
import Signin from '@/components/authen/Signin.vue'
import Signup from '@/components/authen/Signup.vue'
import PrivateForm from '@/components/private/PrivateForm.vue'

Vue.component('Card',Card);
Vue.component('EditForm',EditForm);
Vue.component('CreateForm',CreateForm);
Vue.component('CompleteForm',CompleteForm);
Vue.component('Signin',Signin);
Vue.component('Signup',Signup);
Vue.component('PrivateForm',PrivateForm);
