import Vuex from "vuex"

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
          return context.app.$axios.$get('/laydy.json')
            .then(res => {
              const arr = [];
              for(const key in res) {
                arr.push({ ...res[key], _id : key });
              }
              vueContext.commit('setPosts', arr);
            })
            .catch(e => console.log(e));
        },
        setPosts(vueContext) {
          vueContext.commit('setPosts');
        },
        addPost(vueContext, post) {
          return this.$axios.$post('/laydy.json', post)
          .then(result => {
            vueContext.commit('addPost', { ...post, _id: result.name });
          })
          .catch(e => console.log(e));
        },
        editPost(vueContext, MyData) {
          return this.$axios.$put('/laydy/' + MyData.id + '.json', MyData)
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
