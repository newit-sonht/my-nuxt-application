import Vuex from "vuex"
import Cookie from "js-cookie"

const createStore = () => {
    return new Vuex.Store({
      state: {
        loadedPosts : [],
        token : null
      },
      mutations: {
        getPosts(state) {
          console.log(state.loadedPosts);
          return state.loadedPosts;
        },
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
        },
        clearToken(state) {
          state.token = null;
        },
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
          return this.$axios.$put('/laydy/' + MyData.id + '.json?auth=' + vueContext.state.token, MyData)
          .then()
          .catch(e => {
            console.log(e);
            alert(' Sorry you are not authorized yet !!');
          });
        },

        setPostStatus(vueContext,MyData) {
          // set data
          if(MyData.enable) MyData.enable = false;
          else MyData.enable = true;
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
            vueContext.commit('setToken',result.idToken);
            localStorage.setItem('token',result.idToken);
            localStorage.setItem('tokenExpiration', new Date().getTime() + Number.parseInt(result.expiresIn) * 1000);
            Cookie.set('jwt',result.idToken);
            Cookie.set('expirationDate',new Date().getTime() + Number.parseInt(result.expiresIn) * 1000);
          })
          .catch(e => console.log(e));
        },

        signUp(vueContext, MyData) {
          return this.$axios.$post('https://identitytoolkit.googleapis.com/v1/accounts:signUp?key=' + process.env.apiKey,MyData)
          .then()
          .catch(e => console.log(e));
        },
        initAuth(vueContext , req) {
          let token;
          let experationDate;
          if(req) {
            if(!req.headers.cookie) {
              return;
            }
            const jwtCookies = req.headers.cookie
              .split(';')
              .find(c => c.trim().startsWith('jwt='));
            if(!jwtCookies){
              return;
            }
            token = jwtCookies.split('=')[1];
            experationDate = req.headers.cookie
              .split(';')
              .find(c => c.trim().startsWith('expirationDate='))
              .split('=')[1];
          } else {
            token = localStorage.getItem('token');
            experationDate = localStorage.getItem('tokenExpiration');
          }
          if(new Date().getTime() > +experationDate || !token) {
            console.log('No token or invalid token !');
            vueContext.dispatch('logout');
            return;
          }
          vueContext.commit('setToken',token);
        },
        logout(vueContext) {
          vueContext.commit('clearToken');
          Cookie.remove('jwt');
          Cookie.remove('expirationDate');
          if(process.client){
            localStorage.removeItem('token');
            localStorage.removeItem('tokenExpiration');
          }
        }
      },
      getters: {
        loadedPosts(state) {
          return state.loadedPosts;
        },
        isAuthenticated(state) {
          return state.token != null;
        }
      },
    });
}

export default createStore
