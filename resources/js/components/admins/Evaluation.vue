<template>
  <div id="app">
    <router-view />
    <Navigation :admin="admin"/>
    <v-content>
        <h3 class="mt-5" style="color:#212121; font-family: 'Roboto', sans-serif; text-align: center; font-weight:100;">Evaluation</h3>
        <v-container>


                <v-row class="mt-3" justify="center">

                        <!-- POST ANNOUNCEMENT -->
                        <v-dialog scrollable persistent v-model="postnews" width="500">
                          <template v-slot:activator="{ on }">
                            <v-btn class="font-weight-light mx-auto" v-on:click="clear()" depressed small v-on="on" style="outline:none;">Post Announcement</v-btn>
                          </template>

                          <v-card>
                            <v-toolbar flat>
                              <v-toolbar-title>Post Announcement</v-toolbar-title>
                            </v-toolbar>

                            <v-card-text>
                                    <v-card class="mx-auto mt-3" width="300" flat>
                                        <v-form>
                                                <v-text-field filled label="Post in news feed..." v-model="post"></v-text-field>
                                                <v-alert color="#EF9A9A" dense text  v-if="errors.post" type="error">{{ errors.post[0] }}</v-alert>
                                                <v-select label="Select Academic Year" filled rounded :items="academic_years" v-on:keyup.enter="postNews()" item-value="id" item-text="year_start" clearable v-model="academic_id">
                                                        <template slot="selection" slot-scope="data" >
                                                            {{ data.item.year_start }} - {{data.item.year_end}}
                                                            </template>
                                                        <template slot="item" slot-scope="data" >
                                                            {{ data.item.year_start }} - {{data.item.year_end}}
                                                            </template>
                                                </v-select>
                                                <v-alert color="#EF9A9A" dense text  v-if="errors.academic_id" type="error">{{ errors.academic_id[0] }}</v-alert>
                                                <v-select label="Select Semester" filled rounded :items="semesters" v-on:keyup.enter="postNews()" item-value="id" item-text="sem_name" clearable v-model="semester_id"></v-select>
                                                <v-alert color="#EF9A9A" dense text  v-if="errors.semester_id" type="error">{{ errors.semester_id[0] }}</v-alert>
                                                <v-select label="Select Evaluation Form" filled rounded :items="evaluations" v-on:keyup.enter="postNews()" item-value="id" item-text="title" clearable v-model="form_id"></v-select>
                                                <v-alert color="#EF9A9A" dense text  v-if="errors.form_id" type="error">{{ errors.form_id[0] }}</v-alert>

                                        </v-form>
                                    </v-card>
                                <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn style="outline: none;" @click="postnews = false" v-on:click="clear()" depressed>Cancel</v-btn>
                            <v-btn class="ml-3" style="outline: none;" v-on:click="postNews()"  depressed>Post</v-btn>
                            </v-card-actions>
                            </v-card-text>

                          </v-card>
                        </v-dialog>
                    </v-row>



                        <v-card class="mt-3 mx-auto" width="900">
                            <v-card-title>
                                Posts
                            <v-spacer></v-spacer>
                            <v-text-field v-model="post_search" append-icon="mdi-magnify" label="Search" single-line hide-details></v-text-field>
                            </v-card-title>
                            <v-data-table :headers="post_headers" :search="post_search" :items-per-page="5" :items="posts" class="elevation-1">


                                <template v-slot:item.academic_id="{item}">
                                    <div v-for="academic_year in academic_years" :key="academic_year.id">
                                        <div v-if="item.academic_id === academic_year.id">
                                            {{academic_year.year_start}} - {{academic_year.year_end}}
                                        </div>
                                    </div>
                                </template>


                                <template v-slot:item.semester_id="{item}">
                                    <div v-for="semester in semesters" :key="semester.id">
                                        <div v-if="item.semester_id === semester.id">
                                            {{semester.sem_name}}
                                        </div>
                                    </div>
                                </template>


                                <template v-slot:item.form_id="{item}">
                                    <div v-for="evaluation in evaluations" :key="evaluation.id">
                                        <div v-if="item.form_id === evaluation.id">
                                            {{evaluation.title}}
                                        </div>
                                    </div>
                                </template>

                                <template v-slot:item.actions="{item}">

                                            <!-- Delete Post -->

                                                        <v-icon v-on:click="clickPost(item)" data-toggle="modal" data-target="#deleteQuestion" small>mdi-delete</v-icon>

                                                            <div class="modal fade" id="deleteQuestion" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="exampleModalLongTitle">Delete Post</h5>
                                                                                    </div>
                                                                                    <div class="modal-body">
                                                                                        <div style="text-align: center; font-size: 15px;"> Are you sure? </div>
                                                                                    </div>
                                                                                    <div class="modal-footer">
                                                                                <v-btn depressed style="outline: none;" data-dismiss="modal">Cancel</v-btn>
                                                                                <v-btn depressed style="outline: none;" data-dismiss="modal" v-on:click="deletePost()">Delete</v-btn>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                </template>
                            </v-data-table>
                        </v-card>





                <v-row class="mt-5" justify="center">

                        <!-- CREATE QUESTION FORM -->
                        <v-dialog scrollable persistent v-model="addquestion" width="500">
                          <template v-slot:activator="{ on }">
                            <v-btn class="font-weight-light mx-auto" depressed small v-on="on" style="outline:none;">Create Question</v-btn>
                          </template>

                          <v-card>
                            <v-toolbar flat>
                              <v-toolbar-title>Question Form</v-toolbar-title>
                            </v-toolbar>

                            <v-card-text>
                                    <v-card class="mx-auto mt-3" width="300" flat>
                                        <v-form>
                                            <v-select label="Select Category" filled rounded :items="select_category" v-on:keyup.enter="addQuestion()" v-model="add_ques_category"></v-select>
                                                <v-alert color="#EF9A9A" dense text v-if="errors.ques_category" type="error">{{ errors.ques_category[0] }}</v-alert>
                                            <v-textarea filled label="Write a question..." v-on:keyup.enter="addQuestion()" type="text" v-model="add_ques_statement"></v-textarea>
                                                <v-alert color="#EF9A9A" dense text  v-if="errors.ques_statement" type="error">{{ errors.ques_statement[0] }}</v-alert>
                                        </v-form>
                                    </v-card>
                                <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn style="outline: none;" @click="addquestion = false" v-on:click="clear()" depressed>Cancel</v-btn>
                            <v-btn class="ml-3" style="outline: none;" v-on:click="addQuestion()"  depressed>Save</v-btn>
                            </v-card-actions>
                            </v-card-text>

                          </v-card>
                        </v-dialog>
                    </v-row>


                    <!-- QUESTION TABLE -->
                        <v-card class="mt-3 mx-auto" width="900">
                            <v-card-title>
                                Questions
                            <v-spacer></v-spacer>
                            <v-text-field v-model="question_search" append-icon="mdi-magnify" label="Search" single-line hide-details></v-text-field>
                            </v-card-title>
                            <v-data-table :headers="question_headers" :search="question_search" :items-per-page="5" :items="questions" class="elevation-1">




                                <template v-slot:item.actions="{item}">

                                         <!-- Update Question -->

                                                        <v-icon v-on:click="clickQuestion(item)" data-toggle="modal" data-target="#updateQuestion" small>mdi-pencil</v-icon>

                                                            <div class="modal fade" id="updateQuestion" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="exampleModalLongTitle">Update Question</h5>
                                                                                    </div>
                                                                                    <div class="modal-body">
                                                                                            <v-form>
                                                                                                <v-select label="Select Category" filled rounded :items="select_category" v-on:keyup.enter="addQuestion()" v-model="ques_category"></v-select>
                                                                                                    <v-alert color="#EF9A9A" dense text v-if="errors.ques_category" type="error">{{ errors.ques_category[0] }}</v-alert>
                                                                                                <v-textarea filled label="Write a question..." v-on:keyup.enter="addQuestion()" type="text" v-model="ques_statement"></v-textarea>
                                                                                                    <v-alert color="#EF9A9A" dense text  v-if="errors.ques_statement" type="error">{{ errors.ques_statement[0] }}</v-alert>
                                                                                            </v-form>
                                                                                    </div>
                                                                                    <div class="modal-footer">
                                                                                <v-btn depressed style="outline: none;" data-dismiss="modal" v-on:click="clear()">Cancel</v-btn>
                                                                                <v-btn depressed style="outline: none;" v-on:keyup.enter="updateQuestion()" v-on:click="updateQuestion()">Save Changes</v-btn>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                </template>




                            </v-data-table>
                        </v-card>




                <v-row class="mt-5" justify="center">

                        <!-- CREATE EVALUATION FORM -->
                        <v-dialog scrollable persistent v-model="addform" width="500">
                          <template v-slot:activator="{ on }">
                            <v-btn class="font-weight-light mx-auto" depressed small v-on="on" style="outline:none;">Create Evaluation Form</v-btn>
                          </template>

                          <v-card>
                            <v-toolbar flat>
                              <v-toolbar-title>Evaluation Form</v-toolbar-title>
                            </v-toolbar>

                            <v-card-text>
                              <v-form>
                                    <v-card class="mx-auto mt-3" width="300" flat>
                                <v-text-field filled label="Title" v-on:keyup.enter="addForm()" type="text" v-model="add_title"></v-text-field>
                                    <v-alert color="#EF9A9A" text="#D50000" v-if="errors.title" type="error">{{ errors.title[0] }}</v-alert>
                                <v-select label="Select Type" filled rounded :items="select_type" v-on:keyup.enter="addForm()" v-model="add_type"></v-select>
                                    <v-alert color="#EF9A9A" text="#D50000" v-if="errors.type" type="error">{{ errors.type[0] }}</v-alert>


                                <v-text-field filled v-if="add_type === 'Event Evaluation'" label="Venue" v-on:keyup.enter="addForm()" type="text" v-model="add_venue"></v-text-field>
                                    <v-alert color="#EF9A9A" text="#D50000" v-if="errors.venue" type="error">{{ errors.venue[0] }}</v-alert>
                                <v-text-field filled v-if="add_type === 'Event Evaluation'" label="Speaker" v-on:keyup.enter="addForm()" type="text" v-model="add_speaker"></v-text-field>
                                    <v-alert color="#EF9A9A" text="#D50000" v-if="errors.speaker" type="error">{{ errors.speaker[0] }}</v-alert>

                                    <div>Start Date</div>
                                        <v-text-field dense rounded type="Date" v-model="start_date"></v-text-field>
                                            <v-alert color="#EF9A9A" dense text v-if="errors.start_date" type="error">{{ errors.start_date[0] }}</v-alert>
                                            <div>End Date</div>
                                        <v-text-field dense rounded type="Date" v-model="end_date"></v-text-field>
                                    <v-alert color="#EF9A9A" dense text v-if="errors.end_date" type="error">{{ errors.end_date[0] }}</v-alert>
                                    </v-card>
                                </v-form>

                                <v-card-actions>
                            <v-spacer></v-spacer>
                            <v-btn style="outline: none;"  @click="addform = false" v-on:click="clear()" depressed>Cancel</v-btn>
                            <v-btn class="ml-3" style="outline: none;" v-on:click="addForm()"  depressed>Save</v-btn>
                            </v-card-actions>
                            </v-card-text>
                          </v-card>
                        </v-dialog>
                    </v-row>


                    <!-- EVALUATION FORM TABLE -->
                        <v-card class="mt-3 mx-auto" width="900">
                            <v-card-title>
                                Evaluation Forms
                            <v-spacer></v-spacer>
                            <v-text-field v-model="evaluation_search" append-icon="mdi-magnify" label="Search" single-line hide-details></v-text-field>
                            </v-card-title>
                            <v-data-table :headers="evaluation_headers" :search="evaluation_search" :items-per-page="5" :items="evaluations" class="elevation-1">



                                <!-- Question Form -->
                                <template v-slot:item.add_question="{item}">

                                        <v-icon v-on:click="clickEvaluation(item)" data-toggle="modal" data-target="#questionForm" class="ml-4" small>mdi-file-question</v-icon>

                                            <div class="modal fade bd-example-modal-lg"  data-backdrop="static" data-keyboard="false" id="questionForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLongTitle">Questions</h5>
                                                                    </div>
                                                                    <div class="modal-body">

                                                                    <v-card class="mx-auto" width="400" flat>
                                                                        <v-form>
                                                                            <v-card-title>Select Questions</v-card-title>
                                                                                <v-autocomplete filled rounded :items="questions" v-on:keyup.enter="addQuestionForm()" item-value="id" item-text="ques_category" clearable v-model="add_ques_id">
                                                                                     <template slot="selection" slot-scope="data" >
                                                                                            {{ data.item.ques_category }} - {{data.item.ques_statement}}
                                                                                            </template>
                                                                                        <template slot="item" slot-scope="data" >
                                                                                            {{ data.item.ques_category }} - {{data.item.ques_statement}}
                                                                                            </template>
                                                                                </v-autocomplete>
                                                                        </v-form>
                                                                        <v-btn style="outline: none;" v-on:click="addQuestionForm()" outlined text small>Save</v-btn>
                                                                    </v-card>


                                                                        <v-card class="mt-4 mb-3 mx-auto" width="700">
                                                                            <!-- QUESTION FORM TABLE -->
                                                                                        <table class="table-bordered">
                                                                                                <thead>
                                                                                                    <th>Categories</th>
                                                                                                    <th>Questions</th>
                                                                                                    <th>Remove</th>
                                                                                                </thead>
                                                                                                <tbody style="background-color: #F5F5F5;" v-for="question in questions" :key="question.id">
                                                                                                    <tr v-for="questionform in questionforms" :key="questionform.id">
                                                                                                            <th v-if="id === questionform.form_id && question.id === questionform.ques_id">{{question.ques_category}}</th>
                                                                                                            <td v-if="id === questionform.form_id && question.id === questionform.ques_id">{{question.ques_statement}}</td>
                                                                                                            <td v-if="id === questionform.form_id && question.id === questionform.ques_id">
                                                                                                                <!-- Delete Question -->
                                                                                                                    <v-icon @click.prevent="deleteQuestionForm(questionform)" small class="ml-3">mdi-delete</v-icon>
                                                                                                            </td>
                                                                                                    </tr>
                                                                                                </tbody>
                                                                                        </table>
                                                                        </v-card>

                                                                    </div>
                                                                    <div class="modal-footer">
                                                                <v-btn depressed style="outline: none;" @click="clear()" data-dismiss="modal">Ok</v-btn>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                </template>


                                <!-- Evaluator Form -->
                                <template v-slot:item.add_evaluator="{item}">

                                        <v-icon v-on:click="clickEvaluation(item)" data-toggle="modal" data-target="#evaluatorForm" small class="ml-4">mdi-account-multiple-plus</v-icon>

                                            <div class="modal fade bd-example-modal-lg" data-backdrop="static" data-keyboard="false" id="evaluatorForm" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable" role="document">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h5 class="modal-title" id="exampleModalLongTitle">Evaluators</h5>
                                                                    </div>
                                                                    <div class="modal-body">

                                                                            <!-- SELECT Section Evaluator -->
                                                                                    <v-card class="mx-auto" width="300" flat>
                                                                                        <v-form>
                                                                                    <v-autocomplete clearable label="Select Section Evaluator" rounded filled dense :items="assigns" item-value="id" item-text="section.sec_code" v-model="assign_id">
                                                                                           <template slot="selection" slot-scope="data" >
                                                                                            {{ data.item.section.sec_code }} - {{data.item.subject.sub_code}} - {{data.item.teacher.fname}} {{data.item.teacher.lname}}
                                                                                            </template>
                                                                                        <template slot="item" slot-scope="data" >
                                                                                            {{ data.item.section.sec_code }} - {{data.item.subject.sub_code}} - {{data.item.teacher.fname}} {{data.item.teacher.lname}}
                                                                                            </template>
                                                                                        </v-autocomplete>
                                                                                        <v-alert color="#EF9A9A" dense text v-if="errors.assign_id" type="error">{{ errors.assign_id[0] }}</v-alert>
                                                                                        </v-form>

                                                                                        <v-btn style="outline: none;" v-on:click="addSectionEvaluator()" outlined text small>Add Evaluators</v-btn>
                                                                                                </v-card>
                                                                                            <v-card class="mt-4 mb-3 mx-auto" width="450">
                                                                                            <!--  Section Evaluator TABLE -->
                                                                                                                <table class="table-bordered">
                                                                                                                        <thead>
                                                                                                                                <th>Section</th>
                                                                                                                                    <th>Subject</th>
                                                                                                                                        <th>Teacher to Evaluate</th>
                                                                                                                                            <th>Remove</th>
                                                                                                                        </thead>
                                                                                                                    <tbody style="background-color: #F5F5F5;" v-for="section_evaluator in section_evaluators" :key="section_evaluator.id">
                                                                                                                            <tr v-for="assign in assigns" :key="assign.id">
                                                                                                                                <td v-if="section_evaluator.form_id === id && section_evaluator.assign_id === assign.id">{{assign.section.sec_code}}</td>
                                                                                                                                <td v-if="section_evaluator.form_id === id && section_evaluator.assign_id === assign.id">{{assign.subject.sub_code}}</td>
                                                                                                                                <td v-if="section_evaluator.form_id === id && section_evaluator.assign_id === assign.id">{{assign.teacher.fname}} {{assign.teacher.lname}}</td>
                                                                                                                                    <!-- Delete Section Evaluator -->
                                                                                                                                <td v-if="section_evaluator.form_id === id && section_evaluator.assign_id === assign.id">
                                                                                                                                    <v-icon small class="ml-3" @click.prevent="deleteSectionEvaluator(section_evaluator)" >mdi-delete</v-icon>
                                                                                                                                    </td>
                                                                                                                            </tr>
                                                                                                                    </tbody>
                                                                                                                </table>
                                                                                                    </v-card>

                                                                                </div>
                                                                                <div class="modal-footer">
                                                                            <v-btn depressed style="outline: none;" @click="clear()" data-dismiss="modal">Ok</v-btn>


                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                            </template>


                                <template v-slot:item.actions="{item}">

                                         <!-- Update Evaluation -->

                                                        <v-icon v-on:click="clickEvaluation(item)" data-toggle="modal" data-target="#updateEvaluation" small>mdi-pencil</v-icon>

                                                            <div class="modal fade" data-backdrop="static" data-keyboard="false" id="updateEvaluation" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                                                                <div class="modal-dialog modal-dialog-centered" role="document">
                                                                    <div class="modal-content">
                                                                        <div class="modal-header">
                                                                            <h5 class="modal-title" id="exampleModalLongTitle">Update Evaluation</h5>
                                                                                    </div>
                                                                                    <div class="modal-body">
                                                                                        <v-form>
                                                                                        <v-card class="mx-auto mt-3" width="300" flat>
                                                                                            <v-text-field filled label="Title" v-on:keyup.enter="updateEvaluation()" type="text" v-model="title"></v-text-field>
                                                                                                <v-alert color="#EF9A9A" text="#D50000" v-if="errors.title" type="error">{{ errors.title[0] }}</v-alert>
                                                                                                    <v-text-field filled v-if="type === 'Event Evaluation'" label="Venue" v-on:keyup.enter="updateEvaluation()" type="text" v-model="venue"></v-text-field>
                                                                                                        <v-alert color="#EF9A9A" text="#D50000" v-if="errors.venue" type="error">{{ errors.venue[0] }}</v-alert>
                                                                                                    <v-text-field filled v-if="type === 'Event Evaluation'" label="Speaker" v-on:keyup.enter="updateEvaluation()" type="text" v-model="speaker"></v-text-field>
                                                                                                        <v-alert color="#EF9A9A" text="#D50000" v-if="errors.speaker" type="error">{{ errors.speaker[0] }}</v-alert>
                                                                                                <div>Start Date</div>
                                                                                                    <v-text-field dense rounded type="Date" v-model="start_date"></v-text-field>
                                                                                                        <v-alert color="#EF9A9A" dense text v-if="errors.start_date" type="error">{{ errors.start_date[0] }}</v-alert>
                                                                                                        <div>End Date</div>
                                                                                                    <v-text-field dense rounded type="Date" v-model="end_date"></v-text-field>
                                                                                                <v-alert color="#EF9A9A" dense text v-if="errors.end_date" type="error">{{ errors.end_date[0] }}</v-alert>
                                                                                                    </v-card>
                                                                                            </v-form>
                                                                                    </div>
                                                                                    <div class="modal-footer">
                                                                                <v-btn depressed style="outline: none;" data-dismiss="modal" v-on:click="clear()">Cancel</v-btn>
                                                                                <v-btn depressed style="outline: none;" v-on:keyup.enter="updateEvaluation()" v-on:click="updateEvaluation()">Save Changes</v-btn>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>


                                </template>




                            </v-data-table>
                        </v-card>




        </v-container>
    </v-content>
    <Footer/>
  </div>
</template>

<script>
import Navigation from "./components/Navigation";
import Footer from "./components/Footer";
export default {
  props: {
    admin: {
      type: Object,
      required: true
    }
  },
  name: "Evaluation",
  components: {
    'Navigation': Navigation,
    'Footer': Footer,
  },

  data: () => ({
      question_search: '',
      evaluation_search: '',
      post_search: '',
        question_headers: [
        {
            text: 'Category',
            value: 'ques_category',
            sortable: false,
            align: 'left'
        },
        { text: 'Questions', value: 'ques_statement' },
        { text: 'Created At', value: 'created_at' },
        { text: 'Updated At', value: 'updated_at' },
        { text: 'Edit', value: 'actions', sortable: false }
        ],
      addquestion: false,
      select_category: ['Commitment', 'Knowledge of the Subject', 'Teaching Effectiveness', 'Management of Learning'],
      add_ques_category: null,
      add_ques_statement: null,
      ques_category: null,
      ques_statement: null,
      id: null,
      questions: [],
        evaluation_headers: [
        {
            text: 'Title',
            value: 'title',
            sortable: false,
            align: 'left'
        },
        { text: 'Type', value: 'type' },
        { text: 'Add Questions', value: 'add_question' },
        { text: 'Add Evaluators', value: 'add_evaluator' },
        { text: 'Started At', value: 'start_date' },
         { text: 'Ended At', value: 'end_date' },

        { text: 'Edit', value: 'actions', sortable: false }
        ],
      addform: false,
      select_type: ['Teacher Evaluation', 'Event Evaluation'],
      add_title: null,
      add_type: null,
      add_venue: null,
      add_speaker: null,
      title: null,
      type: null,
      venue: null,
      speaker: null,
      start_date: null,
      end_date: null,
      evaluations: [],
      add_ques_id: null,
      questionforms: [],
        post_headers: [
        {
            text: 'Post',
            value: 'post',
            sortable: false,
            align: 'left'
        },
        { text: 'Academic Year', value: 'academic_id' },
        { text: 'Semester', value: 'semester_id' },
        { text: 'Evaluation', value: 'form_id' },
        { text: 'Delete', value: 'actions', sortable: false }
        ],
      postnews: false,
      post: null,
      form_id: null,
      academic_id: null,
      semester_id: null,
      semesters: [],
      academic_years: [],
      posts: [],
      assign: [],
      assign_id: [],
      section_evaluators: [],
      errors: []
  }),

  created() {
        this.fetchEvaluation();
  },

  methods: {

    fetchEvaluation() {
      axios.get("/admin/evaluation/view").then(response => {
        this.questions = response.data.questions;
        this.evaluations = response.data.evaluations;
        this.questionforms = response.data.questionforms;
        this.academic_years = response.data.academic_years;
        this.semesters = response.data.semesters;
        this.posts = response.data.posts;
        this.assigns = response.data.assigns;
        this.section_evaluators = response.data.section_evaluators;
      });
    },


    //   QUESTIONS

    clickQuestion: function (question) {
    return (this.id = question.id, this.ques_category = question.ques_category, this.ques_statement = question.ques_statement);
    },

    addQuestion() {
        axios.post("/admin/question/create", {ques_category: this.add_ques_category, ques_statement: this.add_ques_statement})
        .then(response => {
                this.questions.unshift({ id: response.data.id, ques_category:response.data.ques_category, ques_statement: response.data.ques_statement, created_at: response.data.created_at, updated_at: response.data.updated_at});
                this.add_ques_category = "";
                this.add_ques_statement = "";
                this.errors = "";
                this.addquestion = false;
        })
        .catch(error => {
        this.errors = error.response.data.errors;
        });
    },

    updateQuestion() {
   axios.put("/admin/question/update", {id: this.id, ques_category: this.ques_category, ques_statement: this.ques_statement})
   .then(response => {
         window.location.reload()
   })
    .catch(error => {
        this.errors = error.response.data.errors;
       });

    },

    // EVALUATION FORM

    clickEvaluation: function (evaluation) {
    return (this.id = evaluation.id, this.title = evaluation.title, this.type = evaluation.type, this.start_date = evaluation.start_date, this.end_date = evaluation.end_date,
    this.venue = evaluation.venue, this.speaker = evaluation.speaker);
    },

    addForm() {
        axios.post("/admin/evaluation/create", {title: this.add_title, type: this.add_type, start_date:this.start_date, end_date:this.end_date, venue: this.add_venue, speaker: this.add_speaker})
        .then(response => {
                this.evaluations.unshift({ id: response.data.id, title:response.data.title, type: response.data.type, start_date: response.data.start_date, end_date: response.data.end_date,
                venue: response.data.venue, speaker: response.data.speaker});
                this.add_title = "";
                this.add_type = "";
                this.add_venue = "";
                this.add_speaker = "";
                this.errors = "";
                this.start_date = "";
                this.end_date = "";
                this.addform = false;
        })
        .catch(error => {
        this.errors = error.response.data.errors;
        });
    },

    updateEvaluation() {
   axios.put("/admin/evaluation/update", {id: this.id, title: this.title, start_date:this.start_date, end_date:this.end_date, venue: this.venue, speaker: this.speaker})
   .then(response => {
         window.location.reload()
   })
    .catch(error => {
        this.errors = error.response.data.errors;
       });

    },


    // QUESTION IN FORM

    addQuestionForm() {
        axios.post("/admin/evaluation/question/create", {form_id: this.id, ques_id: this.add_ques_id})
        .then(response => {
                this.questionforms.unshift({ id: response.data.id, form_id:response.data.form_id, ques_id: response.data.ques_id, created_at: response.data.created_at, updated_at: response.data.updated_at});
                this.add_ques_id = "";
                this.errors = "";
        })
        .catch(error => {
        this.errors = error.response.data.errors;
        });
    },

    deleteQuestionForm(questionform) {
            axios.post("/admin/evaluation/question/delete", {id: questionform.id})
        .then(response => {
            const questionformIndex = this.questionforms.indexOf(questionform)
            this.questionforms.splice(questionformIndex, 1)
       })
        .catch(error => {
        });
    },

    // POST

    clickPost: function (post) {
    return (this.id = post.id);
    },

    postNews(){
        axios.post("/admin/post", {post: this.post, academic_id: this.academic_id, semester_id: this.semester_id, form_id: this.form_id})
        .then(response => {
         window.location.reload()
        })
        .catch(error => {
        this.errors = error.response.data.errors;
        });
    },

    deletePost() {
            axios.post("/admin/delete/post", {id: this.id})
        .then(response => {
         window.location.reload()
       })
        .catch(error => {
        });
    },

    // SECTION EVALUATORS

    addSectionEvaluator(){
        axios.post("/admin/section/evaluator/create", {form_id: this.id, assign_id: this.assign_id})
        .then(response => {
                this.section_evaluators.unshift({  id: response.data.id, assign_id: response.data.assign_id, form_id:response.data.form_id});
        })
        .catch(error => {
        this.errors = error.response.data.errors;
        });
    },

    deleteSectionEvaluator(section_evaluator) {
            axios.post("/admin/section/evaluator/delete", {id: section_evaluator.id})
        .then(response => {
            const section_evaluatorIndex = this.section_evaluators.indexOf(section_evaluator)
            this.section_evaluators.splice(section_evaluatorIndex, 1)
       })
        .catch(error => {
        });
    },

    clear() {
                this.add_ques_category = "";
                this.add_ques_statement = "";
                this.ques_category = "";
                this.ques_statement = "";
                this.add_title = "";
                this.add_type = "";
                this.title = "";
                this.type = "";
                this.add_venue = "";
                this.add_speaker = "";
                this.venue = "";
                this.speaker = "";
                this.add_ques_id = "";
                this.start_date = "";
                this.end_date = "";
                this.post = "";
                this.academic_id = "";
                this.semester_id = "";
                this.form_id = "";
                this.assign_id = "";
                this.errors = "";
    },

  }
};
</script>
