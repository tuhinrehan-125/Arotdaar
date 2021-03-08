<template>
  <v-container fluid grid-list-xl class="mt-5">
    <v-row justify="center">
      <base-material-snackbar
        v-model="alert"
        type="success"
        v-bind="{
          [parsedDirection[0]]: true,
          [parsedDirection[1]]: true,
        }"
      >
        {{ message }}
      </base-material-snackbar>
      <v-dialog v-model="dialog" persistent max-width="600px">
        <v-card>
          <v-toolbar dark color="primary">
            <v-toolbar-title>{{ headline }}</v-toolbar-title>
            <v-spacer></v-spacer>
            <v-toolbar-items>
              <v-btn dark text @click="dialog = false">
                <v-icon>mdi-close</v-icon>
              </v-btn>
            </v-toolbar-items>
          </v-toolbar>
          <v-card-text>
            <v-container>
              <v-row>
                <v-col cols="12">
                  <v-select
                    :items="expenseCats"
                    :label="$t('select_expense_category')"
                    dense
                    outlined
                    required
                    :rules="expcatRules"
                    v-model="form.exp_cat_id"
                    item-text="name"
                    item-value="id"
                  ></v-select>
                </v-col>
                <v-col cols="12">
                  <v-text-field
                    :label="$t('expense_for')"
                    required
                    outlined
                    dense
                     :rules="expRules"
                    v-model="form.expense_for"
                  ></v-text-field>
                </v-col>
                <v-col cols="12">
                  <v-text-field
                    :label="$t('expense_amount')"
                    outlined
                    dense
                     :rules="amountRules"
                    type="number"
                    v-model="form.amount"
                  ></v-text-field>
                </v-col>

                <!-- <v-col cols="12">
                  <v-text-field
                    label="Ref No"
                    :label="$t('ref_no')"
                     v-model="form.ref_no"
                    outlined
                    dense
                  ></v-text-field>
                </v-col> -->
                <v-col cols="12" style="padding:0px 10px">
                   <v-checkbox
                    v-model="form.monthly_exp"
                    :label="$t('this_is_monthly_expense')"
                  ></v-checkbox>
                </v-col>
                <v-col cols="12">
                  <v-layout row wrap>
                    <v-menu
                      v-model="dateMenu"
                      :close-on-content-click="false"
                      :nudge-right="40"
                      transition="scale-transition"
                      offset-y
                      min-width="290px"
                      max-width="290px"
                    >
                      <template v-slot:activator="{ on }">
                        <v-text-field
                          :label="$t('expense_date')"
                          prepend-icon="mdi-calendar"
                          :value="form.exp_date"
                          v-on="on"
                          readonly
                        ></v-text-field>
                      </template>
                      <v-date-picker
                        v-model="form.exp_date"
                        @input="dateMenu = false"
                      ></v-date-picker>
                    </v-menu>
                  </v-layout>
                </v-col>
                <v-col cols="12">

                  <v-textarea
                    :label="$t('note')"
                    required
                    outlined
                    dense
                    v-model="form.note"
                  ></v-textarea>
                </v-col>
              </v-row>
            </v-container>
            <small>{{ $t("indicates_required_field") }}</small>
          </v-card-text>
          <v-card-actions>
            <v-spacer></v-spacer>
            <v-btn color="blue darken-1" text @click="dialog = false">
              {{ $t("close") }}
            </v-btn>
            <v-btn color="blue darken-1" text @click="addExpense">
              {{ $t("save") }}
            </v-btn>
          </v-card-actions>
        </v-card>
      </v-dialog>
      <v-dialog v-model="confirmation" max-width="300">
        <v-card>
          <v-card-title>
            Are you sure?
            <v-spacer />
            <v-icon aria-label="Close" @click="confirmation = false">
              mdi-close
            </v-icon>
          </v-card-title>
          <v-card-text class="pb-6 pt-12 text-center">
            <v-btn class="mr-3" text @click="confirmation = false"> No </v-btn>
            <v-btn color="success" text @click="confirmDelete()"> Yes </v-btn>
          </v-card-text>
        </v-card>
      </v-dialog>
    </v-row>
    <v-row>
      <v-col>
        <v-btn dark color="indigo" class="float-right" @click="dialog = true">
          <v-icon left> mdi-plus </v-icon>
          {{ $t("add_expense") }}
        </v-btn>
      </v-col>
    </v-row>
    <v-row>
      <v-col cols="12" md="12">
        <v-card v-if="isLoading">
          <v-skeleton-loader class="mx-auto" type="table"></v-skeleton-loader>
        </v-card>
        <v-card v-else>
          <v-card-title>
            {{ $t("expense_list") }}
            <v-spacer></v-spacer>
            <v-text-field
              v-model="search"
              append-icon="mdi-magnify"
              label="Search"
              single-line
              hide-details
            ></v-text-field>
          </v-card-title>
          <v-card-text>
            <v-data-table :headers="headers" :items="expenses" :search="search">
               <template v-slot:item.monthly_exp="{ item }">
                <span v-if="item.monthly_exp==1">Yes</span>
                <span v-else>No</span>
                </template>
              <template v-slot:item.actions="{ item }">
                <v-btn
                  class="mx-2"
                  dark
                  small
                  color="cyan"
                  @click="editExpense(item)"
                >
                  <v-icon dark> mdi-pencil </v-icon>
                </v-btn>
                <v-btn
                  class="mx-2"
                  dark
                  small
                  color="red"
                  @click="deleteExpense(item)"
                >
                  <v-icon dark> mdi-delete </v-icon>
                </v-btn>
              </template>
            </v-data-table>
          </v-card-text>
        </v-card>
      </v-col>
    </v-row>
  </v-container>
</template>

<script>
export default {
  name: "ExpenseList",
  middleware: "auth",
  head: {
    title: "Clients",
  },
  components: {},
  data() {
    return {
      search:'',
      isLoading:false,
      alert: false,
      dateMenu: false,
      dateValue: null,
      headline: this.$t("add_expense"),
      dialog: false,
      update: false,
      message: "",
      expid: "",
      expcatRules: [(v) => !!v || this.$t("category_is_required")],
      expRules: [(v) => !!v || this.$t("expense_is_required")],
      amountRules: [(v) => !!v || this.$t("expense_amount_is_required")],
      confirmation: false,
      direction: "top right",
      expenseCats: [],
      form: {
        monthly_exp:false,
      },
      headers: [
        {
          sortable: false,
          text: this.$t("expense_for"),
          value: "expense_for",
           align: "center",
        },
        {
          sortable: false,
          text: this.$t("amount"),
          value: "amount",
           align: "center",
        },
        {
          sortable: false,
          text: this.$t("expense_date"),
          value: "exp_date",
           align: "center",
        },
        {
          sortable: false,
          text: this.$t("monthly_expense"),
          value: "monthly_exp",
           align: "center",
        },
        {
          sortable: false,
          text: this.$t("expense_category"),
          value: "exp_cat_name",
           align: "center",
        },
        {
          sortable: false,
          text: this.$t("action"),
          value: "actions",
        },
      ],
      expenses: [],
    };
  },
  computed: {
    parsedDirection() {
      return this.direction.split(" ");
    },
  },
  async asyncData({ params, axios }) {},
  mounted() {
    this.getExpCategories();
    this.getExpense();
  },
  methods: {
    async getExpCategories() {
      await this.$axios.get("/expense-category").then((response) => {
        this.expenseCats = response.data;
      });
    },
    async getExpense() {
      this.isLoading=true
      await this.$axios.get("/expense").then((response) => {
        this.isLoading=false
        this.expenses = response.data;
      });
    },
    editExpense(item) {
      this.update = true;
      this.dialog = true;
      this.headline = this.$t("edit_expense");
      this.form.exp_cat_id = item.exp_cat_id;
      this.form.expense_for = item.expense_for;
      this.form.amount = item.amount;
      this.form.ref_no = item.ref_no;
      this.form.exp_date = item.exp_date;
      this.form.note = item.note;
      this.expid = item.id;
    },
    deleteExpense(item) {
      this.confirmation = true;
      this.expid = item.id;
    },
    async confirmDelete() {
      await this.$axios.delete(`expense/${this.expid}`).then((res) => {
        this.alert = true;
        this.message = "Expense Deleted Successfully";
        this.confirmation = false;
        this.getExpense();
      });
    },
    async addExpense() {
      if (this.update == false) {
        await this.$axios.post("expense", this.form).then((res) => {
          this.form={}
          this.message = "Expense Addedd successfully";
          this.dialog = false;
          this.alert = true;
          this.getExpense();
        });
      } else {
        await this.$axios
          .patch(`expense/${this.expid}`, this.form)
          .then((res) => {
             this.form={}
            this.message = "Expense Updated successfully";
            this.dialog = false;
            this.alert = true;
            this.getExpense();
          });
      }
    },
  },
};
</script>

<style>
</style>
