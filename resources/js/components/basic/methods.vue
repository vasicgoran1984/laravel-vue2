<template>
    <div>
        <h2>some data here {{counter}}</h2>
        <button @click="updateCounter(1)">Increase</button>
        <button @click="updateCounter(-1)">Decrease</button>

    <br/>
    <div v-for="(blog, i) in blogs" :key="i" v-if="blogs.length">
        <h3>{{i+1}} {{blog.title}}</h3>
        <p>{{blog.post}}</p>
    </div>

    <div>
        <h2 v-if="showItem">show this item if "showItem" is true</h2>
        <h2 v-else>hide this item if "showItem" is false</h2>
    </div>

    <button @click="showItem = !showItem">Change showItem</button>
    </div>
</template>

<script>
export default {
    data() {
        return {
            counter: 0,
            blogs: [],
            showItem: false,
        }
    },
    methods: {
        updateCounter(number) {
            this.counter += number
        },
        changeShowItem() {
            this.showItem = !this.showItem
        }
    },

    created() {
        this.counter = 100
        // get the blog posts from server - example
        let posts = [
            {title: 'this is blog title', post: 'this is the post', id: 1},
            {title: 'this is new theme', post: 'this is the post', id: 2},
            {title: 'this new blog', post: 'this is the post', id: 3},
            {title: 'this is blog something else', post: 'this is the post', id: 4},
            {title: 'this is blog title', post: 'this is the post', id: 5},
        ]
        this.blogs = posts
    }
}
</script>
