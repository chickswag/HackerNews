<template>
        <div class="card-body">
                <div class="d-flex hacker-bg p-2">
                        <span><b class="btn flex-grow-1"><img src="https://news.ycombinator.com/y18.gif"/> <i class="fa fa-list"></i> <router-link to="/">Hacker News</router-link></b></span>
                        <span class="btn flex-grow-1"><i class="fa fa-refresh"></i> <router-link to="/"> Home</router-link></span>
                        <span class="btn flex-grow-1" ><i class="fa fa-refresh"></i><router-link to="/story/new"> New</router-link></span>
                        <span class="btn flex-grow-1" ><i class="fa fa-arrow-up"></i> <router-link to="/story/top"> Top</router-link></span>
                        <span class="btn flex-grow-1" ><i class="fa fa-thumbs-up"></i><router-link to="/story/best"> Best</router-link></span>

                </div>
                <router-view/>
        </div>

</template>

<script>

</script>