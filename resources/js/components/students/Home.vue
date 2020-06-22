<template>
  <div id="app">
    <router-view />
    <Navigation :student="student" />
    <v-content>
        <h3 class="mt-5" style="color:#212121; font-family: 'Roboto', sans-serif; text-align: center; font-weight:100;">News Feed</h3>
        <v-container>
                <v-card v-for="post in posts" :key="post.id" class="mx-auto mt-4" width="600">
                    <div>
                    <v-card-subtitle>Evaluation Form: {{post.evaluation_form.title}}
                        <br>
                        {{post.semester.sem_name}} {{post.academic_year.year_start}} - {{post.academic_year.year_end}}
                    </v-card-subtitle>
                    <v-card-text>
                        {{post.post}}
                        </v-card-text>
                    </div>
                        <v-footer>
                            <v-spacer></v-spacer>
                            <div style="color:#757575;">{{post.created_at}}</div>
                        </v-footer>
                </v-card>
        </v-container>
    </v-content>
    <Footer />
  </div>
</template>

<script>
import Navigation from "./components/Navigation";
import Footer from "./components/Footer";
export default {
  props: {
    student: {
      type: Object,
      required: true
    }
  },
  name: "Home",
  components: {
    Navigation: Navigation,
    Footer: Footer
  },
  data(){return{
      posts: []
    }},


  mounted(){
        this.fetchPost();
  },

  methods:{
    fetchPost(){
      axios.get('/student/post').then(response => {
        this.posts = response.data.posts;
      });
    },

  }
};
</script>
