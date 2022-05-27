import Vuex from "vuex"
import axios from "axios"

const createStore = () => {
    return new Vuex.Store({
      state: {
        loadedPosts : []
      },
      mutations: {
        setPosts(state, posts){
          state.loadedPosts = posts;
        }
      },
      actions: {
        nuxtServerInit(vueContext, context) {
          return axios.get('https://my-nuxt-project-3148e-default-rtdb.asia-southeast1.firebasedatabase.app/laydy.json')
            .then(res => {
              const arr = []
              for(const key in res.data) {
                arr.push({ ...res.data[key] });
              }
              vueContext.commit('setPosts', arr);
            })
            .catch(e => console.log(e));
        },
        setPosts(vueContext) {
          vueContext.commit('setPosts');
        }
      },
      getters: {
        loadedPosts(state) {
          return state.loadedPosts;
        }
      },
    });
}

export default createStore
