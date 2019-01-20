<?php namespace App\Lib;

use App\Models\Company\Company;
use App\Models\Contact\Contact;
use App\Models\Inventory\Stock;
use App\Models\MedicineTakingSchedule;
use App\Models\Moneyin\CreditNote;
use App\Models\Moneyin\Invoice;
use App\Models\Moneyin\InvoiceEntry;
use App\Models\Moneyin\ExcessPayment;
use App\Models\Moneyin\PaymentReceiveEntryModel;
use App\Models\Moneyin\PaymentReceives;
use App\Models\Moneyin\CreditNotePayment;
use App\Models\Inventory\Item;
use App\Models\MoneyOut\PaymentMadeEntry;
use App\Models\MoneyOut\PaymentMade;
use App\Models\Patient;
use App\Models\Recruit_Customer\Recruit_customer;
use App\Models\Sales\FinalSales;
use App\Models\Sales\FinalSalesEntry;
use App\Models\Sales\FinalSalesFreeReturnEntry;
use App\Models\Sales\FinalSalesReturnEntry;
use App\Models\Tax;
use App\Models\ManualJournal\JournalEntry;
use App\Models\MoneyOut\Bill;
use App\Models\MoneyOut\BillEntry;
use App\Models\Damage\DamageItem;
use App\Models\Damage\DamageAdjustmentEntry;
use App\Models\Moneyin\CreditNoteEntry;
use App\Models\Contact\Road;
use DateTime;

use DB;
use Illuminate\Support\Facades\Auth;
use NumberFormatter;

class Helpers {

    public function getPatientSerial($id){
        $patient = Patient::select('serial')->where('id', $id)->first();
        return "PID-".str_pad($patient['serial'], 6, '0', STR_PAD_LEFT);
    }
    public function getPatientAge($id){
        $patient = Patient::select('age')->where('id', $id)->first();
        return $patient['age'];
    }
    public function getPatientName($id){
        $patient = Patient::select('name')->where('id', $id)->first();
        return $patient['name'];
    }

    public function medicineTakingSchedule($id){
        $medicine_schedule = MedicineTakingSchedule::select('schedule')->where('id', $id)->first();
        return $medicine_schedule['schedule'];
    }

}