<template>
    <div class="card-body">
        <h4 class="card-header mt-4"  v-model="title"><i class="fa fa-list"></i> {{ title }}</h4>
        <hr/>
        <div class="d-flex hacker-bg p-2">
            <span class="btn  flex-grow-1" title="NEW STORIES" @click="newStories()"><i class="fa fa-refresh"></i>&nbsp;&nbsp;&nbsp;New </span>
            <span class="btn  flex-grow-1" title="TOP STORIES" @click="topStories()"><i class="fa fa-arrow-up"></i>&nbsp;&nbsp;&nbsp;Top</span>
            <span class="btn  flex-grow-1" title="BEST STORIES" @click="bestStories()"><i class="fa fa-thumbs-up"></i>&nbsp;&nbsp;&nbsp;Best</span>
        </div>
        <div v-if="posts.length">
            <table class="table table-striped">
                <thead>
                <tr><td>#</td><td>Title</td></tr>
                </thead>
                <tbody>

                <tr v-for="(post,index ) in posts" :key="task.id">
                    <td>{{index+1}}</td>
                    <td>{{ post.title}}</td>

                </tr>
                </tbody>

            </table>
<!--            <pagination :data="tasks">-->
<!--                <span slot="prev-nav">&lt; Previous</span>-->
<!--                <span slot="next-nav">Next &gt;</span>-->
<!--            </pagination>-->
        </div>


        <div v-else class="mb-4">
            No posts yet<br/>
        </div>


    </div>

</template>
<style>
    .hacker-bg{
        background-color: #ff6600;
    }
</style>
<script>

    export default {

        data() {
            return {
                posts: [],
                post:{
                    id: '',
                    title: '',
                },
                post_id: '',
                title : "Hacker News",
                edit:false,
                pagination:{},

            };
        },

        methods: {
            fetchPosts(page = 1) {
                axios.get('api/Posts?page=' + page).then((response) => {
                    this.posts = response.data.handle_data;
                })

            },
            bestStories(){},
            newStories(){},
            topStories(){},
        },
        updated() {
            this.fetchPosts();
        },
        mounted(){
            this.fetchPosts();
        },
    }
</script>

