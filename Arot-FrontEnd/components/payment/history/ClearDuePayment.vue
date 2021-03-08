<template>
  <v-dialog v-model="isOpened" persistent max-width="600px">
    <v-card>
      <v-toolbar dark color="primary">
        <v-toolbar-title> {{ $t("add_payment") }}</v-toolbar-title>
        <v-spacer></v-spacer>
        <v-toolbar-items>
          <v-btn dark text @click="closeModal">
            <v-icon>mdi-close</v-icon>
          </v-btn>
        </v-toolbar-items>
      </v-toolbar>
      <v-card-text>
        <v-container>
          <v-form ref="form" v-model="valid" lazy-validation>
            <v-row class="mt-5">
              <v-col cols="12" sm="6" md="6">
                <v-text-field
                  :label="$t('due_amount')"
                  type="number"
                  outlined
                  dense
                  required
                  :rules="dueAmountRules"
                  v-model="amount"
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="6" md="6">
                <v-text-field
                  :label="$t('due_advance_amount')"
                  type="number"
                  outlined
                  dense
                  :rules="dueAdvanceRules"
                  v-model="adjust_advance"
                ></v-text-field>
              </v-col>
              <v-col cols="12" sm="6" md="6">
                <v-select
                  :items="payment_from"
                  :label="$t('select_payment_method')"
                  dense
                  outlined
                  required
                  v-model="payment_method"
                ></v-select>
              </v-col>
            </v-row>
           <v-row class="mt-5">
              <!-- for bank -->
              <template v-if="bybank">
                <v-col cols="6" sm="6" md="6">
                  <p class="body-2">{{ $t("bank_name") }}</p></v-col
                >
                <v-col cols="6" sm="6" md="6">
                  <v-select
                    :items="allbanks"
                    :label="$t('bank_name')"
                    dense
                    outlined
                    :required="!bybank"
                    :rules="bybank ? banknameRules : []"
                    v-model="bank"
                    item-text="bank_name"
                    item-value="id"
                  ></v-select>
                </v-col>
                <v-col cols="6" sm="6" md="6">
                  <p class="body-2">{{ $t("acc_no") }}</p></v-col
                >
                <v-col cols="6" sm="6" md="6">
                  <v-text-field
                    :label="$t('acc_no')"
                    outlined
                    dense
                    disabled
                    :required="!bybank"
                    :rules="bybank ? bankcodeRules : []"
                    v-model="bank_acc"
                  ></v-text-field>
                </v-col>
              </template>

              <!-- for bank -->
              <!-- for bkash -->
              <template v-if="bybkash">
                <v-col cols="6" sm="6" md="6">
                  <p class="body-2">{{ $t("from_bkash") }}</p></v-col
                >
                <v-col cols="6" sm="6" md="6">
                  <v-select
                    :items="allbkash"
                    :label="$t('from_bkash')"
                    dense
                    outlined
                    :required="!bybkash"
                    :rules="bybkash ? frombkashRules : []"
                    v-model="from_bKash"
                    item-text="bkash_number"
                    item-value="bkash_number"
                  ></v-select>
                </v-col>
                <v-col cols="6" sm="6" md="6">
                  <p class="body-2">{{ $t("to_bkash") }}</p></v-col
                >
                <v-col cols="6" sm="6" md="6">
                  <v-text-field
                    :label="$t('to_bkash')"
                    outlined
                    dense
                    :required="!bybkash"
                    :rules="bybkash ? tobkashRules : []"
                    v-model="to_bKash"
                  ></v-text-field>
                </v-col>

                <!-- <v-col cols="6" sm="6" md="6">
                   <v-text-field
                        :label="$t('advance_amount')"
                        outlined
                        dense
                        :disabled="form.adjust_advance==0"
                        v-model="form.adjust_advance"
                      ></v-text-field>

                </v-col> -->
              </template>

              <!-- for bkash -->
            </v-row>
          </v-form>
        </v-container>
        <small>{{ $t("indicates_required_field") }}</small>
      </v-card-text>
      <v-card-actions>
        <v-spacer></v-spacer>
        <v-btn color="blue darken-1" text @click="closeModal">
          {{ $t("close") }}
        </v-btn>
        <v-btn color="blue darken-1" text @click="submitForm">
          {{ $t("save") }}
        </v-btn>
      </v-card-actions>
    </v-card>
  </v-dialog>
</template>

<script>
export default {
  name: "ClearDuePayment",
  head: {
    title: "Payment History",
  },
  components: {},
  props: ["client","dueamount", "payments", "clientId"],
  data() {
    return {
      valid: true,
      dueAmountRules: [
        (v) =>
          v <= this.dueamount ||
          "Payment Amount can not be greater than due amount",
      ],
      dueAdvanceRules: [
        (v) =>
          v <= this.client.advance_ude ||
          "Amount can not be greater than advance amount",
      ],
      frombkashRules: [v => !!v || "From bkash number is required"],
      tobkashRules: [v => !!v || "To bkash number is required"],
      banknameRules:[v => !!v || "Bank name is required"],
      bankcodeRules:[v => !!v || "Bank Account is required"],
      banks: [],
      adjust_advance:0,
      bybkash: false,
      bybank: false,
      amount: "",
      payment_from: ["Bkash", "Bank", "Cash"],
      payment_method: "Cash",
      from_bKash: "",
      to_bKash: "",
      bank_acc: "",
      bank: "",
      allbanks:[],
      allbkash:[]
    };
  },
  computed: {
    dueAmountIds() {
      let payments = this.payments.map((item) => {
        if (item.payment_status == "Due" || item.payment_status == "Partial") {
          return item.id;
        }
      });
      return payments.filter(function (element) {
        return element !== undefined;
      });
    },
    isOpened() {
      return this.$store.getters.modal;
    },
  },
  async asyncData({ params, axios }) {},
  mounted() {
  },
  methods: {
    closeModal() {
      this.$store.commit("SET_MODAL", false);
    },
    async getBanks() {
      await this.$axios.get("/banks").then((response) => {
        this.banks = response.data;
      });
    },
      async getAccInfo(type) {
      await this.$axios.get("/account-info?type=" + type).then((response) => {
        if (response.data.type == "Bank") {
          this.allbanks = response.data.data;
        }
        else if (response.data.type == "Bkash") {
          this.allbkash = response.data.data;
        }
      });
    },
    async submitForm() {
      if (this.$refs.form.validate()) {
        await this.$axios
          .post("/bulkpayment", {
            adjust_advance:this.adjust_advance,
            payment_method: this.payment_method,
            from_bKash:this.from_bKash,
            to_bKash:this.to_bKash,
            bank_id:this.bank,
            amount: this.amount,
            id: this.dueAmountIds,
            client_id: this.clientId,
          })
          .then((response) => {
            this.amount = "";
            this.$refs.form.reset();
            setTimeout(() => this.$store.commit("SET_MODAL", false), 10);
            this.$emit("paymentRefresh");
          });
      }
    },
  },
  watch: {
     bank(val) {
      let bank = this.allbanks.find((item) => {
        return val == item.id;
      });
      this.bank_acc = bank.bank_acc;
    },
    payment_method(val) {
      if (val == "Bank") {
        this.getAccInfo("Bank");
        this.from_bKash = "";
        this.to_bKash = "";
        this.bybkash = false;
        this.bybank = true;
      } else if (val == "Bkash") {
        this.getAccInfo("Bkash");
        this.bank_acc = "";
        this.bank_id = "";
        this.bybkash = true;
        this.bybank = false;
      } else {
        this.from_bKash = "";
        this.to_bKash = "";
        this.bank_acc = "";
        this.bank_id = "";
        this.bybkash = false;
        this.bybank = false;
      }
    },
  },
};
</script>

<style>
</style>
