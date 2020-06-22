<template>
  <div id="app">
    <router-view />
    <Navigation :student="student" />
    <v-content>
        <h3 class="mt-5" style="color:#212121; font-family: 'Roboto', sans-serif; text-align: center; font-weight:100;">Evaluation</h3>
             <v-container>

<!-- EVALUATION FORM TABLE -->
<v-card class="mt-3 mx-auto" flat width="1200">
    <v-card-title>
        Evaluation Form
    </v-card-title>
    <div v-for="teacher_evaluation in teacher_evaluations" :key="teacher_evaluation.id">
        <div v-for="assign in assigns" :key="assign.id">
        <v-simple-table style="background-color: #F5F5F5;" fixed-header>
        <template v-slot:default>
                    <thead>
                            <tr v-if="teacher_evaluation.assign.sec_id === student.sec_id && teacher_evaluation.assign_id === assign.id">
                                <th class="text-left">Title</th>
                                <th class="text-left">Type</th>
                                <th class="text-left">Start</th>
                                <th class="text-left">End</th>
                                <th class="text-left">Subject</th>
                                <th class="text-left">Teacher</th>
                                <th class="text-left">Rate</th>
                            </tr>
                    </thead>
                    <tbody>
                        <tr v-if="teacher_evaluation.assign.sec_id === student.sec_id && teacher_evaluation.assign_id === assign.id">
                            <td>{{teacher_evaluation.evaluation.title}}</td>
                            <td>{{teacher_evaluation.evaluation.type}}</td>
                            <td>{{teacher_evaluation.evaluation.start_date}}</td>
                            <td>{{teacher_evaluation.evaluation.end_date}}</td>
                            <td>{{assign.subject.sub_desc}}</td>
                            <td>{{assign.teacher.fname}} {{assign.teacher.lname}}</td>
                            <td>

<v-icon class="ml-2" v-on:click="clickForm(teacher_evaluation) && clickAssign(assign)" data-toggle="modal" data-target="#evaluateForm" small>mdi-clipboard-text</v-icon>

<div class="modal fade" data-backdrop="static" data-keyboard="false" id="evaluateForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog modal-full modal-dialog-centered" role="document">
            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLongTitle">{{teacher_evaluation.evaluation.title}}</h5>
                                        <v-spacer></v-spacer>
                                        <v-btn text style="outline: none;" data-dismiss="modal">Close</v-btn>
                                            </div>
                                            <div class="modal-body">

                                                        <v-card class="mt-3 mx-auto" width="900">
                                                                    <v-simple-table fixed-header>
                                                                    <template v-slot:default>
                                                                                <thead>
                                                                                        <tr>
                                                                                            <th class="text-left">Categories</th>
                                                                                            <th class="text-left">Scale</th>
                                                                                        </tr>
                                                                                </thead>
                                                                                <tbody>
                                                                                    <tr v-for="(question_form, i) in question_forms" :key="question_form.id">
                                                                                        <td>{{question_form.question_details.ques_statement}}</td>
                                                                                        <td>
                                                                                            <br>
                                                                                            <div class="form-check form-check-inline">
                                                                                                <input class="form-check-input" type="radio" :value="{category: question_form.question_details.ques_category, statement: question_form.question_details.ques_statement, rate: 5}" v-model="choices[i]" checked>
                                                                                                <label class="form-check-label">
                                                                                                    Outstanding &nbsp; &nbsp;
                                                                                                </label>
                                                                                                </div>
                                                                                            <div class="form-check form-check-inline">
                                                                                                <input class="form-check-input" type="radio" :value="{category: question_form.question_details.ques_category, statement: question_form.question_details.ques_statement, rate: 4}" v-model="choices[i]" checked>
                                                                                                <label class="form-check-label">
                                                                                                    Very Satisfactory &nbsp; &nbsp;
                                                                                                </label>
                                                                                                </div>
                                                                                            <div class="form-check form-check-inline">
                                                                                                <input class="form-check-input" type="radio" :value="{category: question_form.question_details.ques_category, statement: question_form.question_details.ques_statement, rate: 3}" v-model="choices[i]" checked>
                                                                                                <label class="form-check-label">
                                                                                                    Satisfactory &nbsp; &nbsp;
                                                                                                </label>
                                                                                                </div>
                                                                                            <div class="form-check form-check-inline">
                                                                                                <input class="form-check-input" type="radio" :value="{category: question_form.question_details.ques_category, statement: question_form.question_details.ques_statement, rate: 2}" v-model="choices[i]" checked>
                                                                                                <label class="form-check-label">
                                                                                                    Fair &nbsp; &nbsp;
                                                                                                </label>
                                                                                                </div>
                                                                                            <div class="form-check form-check-inline">
                                                                                                <input class="form-check-input" type="radio" :value="{category: question_form.question_details.ques_category, statement: question_form.question_details.ques_statement, rate: 1}" v-model="choices[i]" checked>
                                                                                                <label class="form-check-label">
                                                                                                    Poor &nbsp; &nbsp;
                                                                                                </label>
                                                                                                </div>
                                                                                                <br>
                                                                                        </td>
                                                                                    </tr>
                                                                                </tbody>
                                                                    </template>
                                                                    </v-simple-table>

                                                            </v-card>

                                            </div>

                                            <v-row justify="center">
                                                <v-card class="mx-auto" flat>
                                                <v-btn style="outline: none;" class="ml-3" v-on:click="addTeacherEvaluation()" depressed dark color="#0288D1" type="submit">Submit</v-btn>
                                                </v-card>
                                            </v-row>
                                            <div class="modal-footer">
                                        <div>EMS &copy; {{ new Date().getFullYear() }}</div>
                                </div>
                            </div>
                        </div>
                    </div>

                                                    </td>
                                                </tr>
                                            </tbody>
                                    </template>
                                </v-simple-table>
                                </div>
                            </div>
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
      form_id: null,
      title: null,
      teacher_fname: null,
      teacher_lname: null,
      sub_desc: null,
       teacher_evaluations: [],
       assigns: [],
       question_forms: [],
      choices: [],
      student_statuses: null
  }),

  created() {
        this.fetchteacherevaluation();
        },

  methods: {


      clickForm: function (teacher_evaluation) {
    return (this.form_id = teacher_evaluation.form_id, this.title = teacher_evaluation.evaluation.title);
    },

      clickAssign: function (assign) {
    return (this.teacher_fname = assign.teacher.fname, this.teacher_lname = assign.teacher.lname, this.sub_desc = assign.subject.sub_desc);
    },

    fetchteacherevaluation(){
      axios.get('/student/teacher/evaluation').then(response => {
        this.teacher_evaluations = response.data.teacher_evaluations;
        this.assigns = response.data.assigns;
        this.question_forms = response.data.question_forms;
        this.student_statuses = response.data.student_statuses;
      });
    },


    addTeacherEvaluation(){
      axios.post('/student/teacher/evaluation',{ choices: this.choices, form_id: this.form_id, title:this.title,
      teacher_fname:this.teacher_fname, teacher_lname:this.teacher_lname, sub_desc:this.sub_desc})
      .then((response)=> {
        window.location.reload()
      })
        .catch(error => {
        this.errors = error.response.data.errors;
        });
    },

    }
};
</script>

<style>
.modal-full {
    min-width: 100%;
    margin: 0;
}

.modal-full .modal-content {
    min-height: 100vh;
}
</style>
