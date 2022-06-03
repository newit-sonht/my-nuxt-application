import Vuex from "vuex"

const createStore = () => {
    return new Vuex.Store({
      state: {
        loadedPosts : [],
        token : null
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
        },
        setToken(state, token) {
          state.token = token;
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
              vueContext.commit('setPosts', arr.reverse());
            })
            .catch(e => console.log(e));
        },

        setPosts(vueContext) {
          vueContext.commit('setPosts');
        },

        addPost(vueContext, post) {
          return this.$axios.$post('/laydy.json?auth=' + vueContext.state.token, post)
          .then(result => {
            vueContext.commit('addPost', { ...post, _id: result.name });
          })
          .catch(e => {
            console.log(e);
            alert(' Sorry you are not authorized yet !!');
          });
        },

        editPost(vueContext, MyData) {
          console.log('editPost token : ', vueContext.state.token);
          return this.$axios.$put('/laydy/' + MyData.id + '.json?auth=' + vueContext.state.token, MyData)
          .then()
          .catch(e => {
            console.log(e);
            alert(' Sorry you are not authorized yet !!');
          });
        },

        signIn(vueContext, MyData) {
          return this.$axios.$post('https://identitytoolkit.googleapis.com/v1/accounts:signInWithPassword?key=' + process.env.apiKey,MyData)
          .then(result => {
            console.log(result);
            vueContext.commit('setToken',result.idToken);
          })
          .catch(e => console.log(e));
        },

        signUp(vueContext, MyData) {
          return this.$axios.$post('https://identitytoolkit.googleapis.com/v1/accounts:signUp?key=' + process.env.apiKey,MyData)
          .then()
          .catch(e => console.log(e));
        },

      },
      getters: {
        loadedPosts(state) {
          return state.loadedPosts;
        }
      },
    });
}

export default createStore
