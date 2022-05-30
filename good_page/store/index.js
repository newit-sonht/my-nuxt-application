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
        },
        addPost(state, post) {
          state.loadedPosts.push(post);
        },
        editPost(state, editedPost) {
          const PostIndex = state.loadedPosts.findIndex(
            post => post.id === editedPost.id
          );
          state.loadedPosts[PostIndex] = editedPost;
        }
      },
      actions: {
        nuxtServerInit(vueContext, context) {
          return axios.get('https://my-nuxt-project-3148e-default-rtdb.asia-southeast1.firebasedatabase.app/laydy.json')
            .then(res => {
              const arr = [];
              for(const key in res.data) {
                arr.push({ ...res.data[key], _id : key });
              }
              vueContext.commit('setPosts', arr);
            })
            .catch(e => console.log(e));
        },
        setPosts(vueContext) {
          vueContext.commit('setPosts');
        },
        addPost(vueContext, post) {
          return axios.post('https://my-nuxt-project-3148e-default-rtdb.asia-southeast1.firebasedatabase.app/laydy.json', post)
          .then(result => {
            vueContext.commit('addPost', { ...post, _id: result.data.name });
          })
          .catch(e => console.log(e));
        },
        editPost(vueContext, MyData) {
          return axios.put('https://my-nuxt-project-3148e-default-rtdb.asia-southeast1.firebasedatabase.app/laydy/' +
          MyData.id
          + '.json', MyData)
          .then()
          .catch(e => console.log(e));
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
