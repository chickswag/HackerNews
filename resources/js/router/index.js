import Vue from 'vue'
import VueRouter from 'vue-router'
import Comments from '../components/Comments'
import NewPosts from '../components/NewPosts'
import BestPosts from '../components/BestPosts'
import TopPosts from '../components/TopPosts'
import Posts from '../components/Posts'

Vue.use(VueRouter)
export default new VueRouter({
    routes: [
        {
            path :'/',
            component : Posts
        },
        {
            path :'/story/new',
            component : NewPosts
        },
        {
            path :'/story/best',
            component : BestPosts
        },
        {
            path :'/story/top',
            component : TopPosts
        },
        {
            path :'/comment/:item',
            component : Comments,

        },

    ]
})
