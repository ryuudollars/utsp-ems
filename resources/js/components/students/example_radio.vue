<template>
  <div id="app">
    <router-view />
    <Navigation :student="student" />
    <v-content>
        <h3 class="mt-5" style="color:#212121; font-family: 'Roboto', sans-serif; text-align: center; font-weight:100;">Evaluation</h3>
             <v-container>

                    <!-- EVALUATION FORM TABLE -->
                        <v-card class="mt-3 mx-auto" flat width="600">
                            <v-card-title>
                                Evaluation Form
                            </v-card-title>
                                <v-simple-table style="background-color: #F5F5F5;" fixed-header>
                                <template v-slot:default>
                                            <thead>
                                                    <tr>
                                                        <th class="text-left">Questions</th>
                                                        <th class="text-left">Choices</th>
                                                    </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="(question, i) in questions" :key="question.id">
                                                    <td>{{question.name}}</td>
                                                    <td>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" :value="[question.name, 1]" v-model="choices[i]" checked>
                                                            <label class="form-check-label">
                                                                1
                                                            </label>
                                                            </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" :value="[question.name, 2]" v-model="choices[i]" checked>
                                                            <label class="form-check-label">
                                                                2
                                                            </label>
                                                            </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" :value="[question.name, 3]" v-model="choices[i]" checked>
                                                            <label class="form-check-label">
                                                                3
                                                            </label>
                                                            </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" :value="[question.name, 4]" v-model="choices[i]" checked>
                                                            <label class="form-check-label">
                                                                4
                                                            </label>
                                                            </div>
                                                        <div class="form-check">
                                                            <input class="form-check-input" type="radio" :value="[question.name, 5]" v-model="choices[i]" checked>
                                                            <label class="form-check-label">
                                                                5
                                                            </label>
                                                            </div>

                                                    </td>
                                                </tr>
                                            </tbody>
                                </template>
                                </v-simple-table>

                                {{choices}}
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

  name: "Student_Evaluation",

  components: {
    Navigation: Navigation,
    Footer: Footer
  },

  data:  () => ({
      choices: [],
      questions: [
        {name:'What'},
        {name:'When'},
        {name:'Where'},
        {name:'Why'},
        {name:'Who'}
      ]
  }),

  created() {},

  methods: {}
};
</script>

