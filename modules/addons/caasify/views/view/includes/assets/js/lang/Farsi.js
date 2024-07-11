
let messages = {
}

let errors = {
}



let common = {
// order view 
        
    // from product
        "download" : "دانلود",
        "upload" : "بارگذاری",
        "backtoservices" : "بازگشت به خدمات",
        "ghz" : "گیگاهرتز",
        "mb" : "مگابایت",
        "gb" : "گیگابایت",
        "core" : "هسته",
        "hostname" : "نام سرور",
        "pending" : "در انتظار",
        "processing" : "در حال پردازش",
        "active" : "فعال",
        "passive" : "غیر فعال",
        "online" : "آنلاین",
        "offline" : "آفلاین",
        "memory" : "حافظه",
        "disk" : "دیسک",
        "cpu" : "پردازنده",
        "template" : "قالب",
        "uptime" : "زمان کارکرد",
        "and" : " و ",
        "days" : "روز",
        "hours" : "ساعت",
        "minutes" : "دقیقه",
        "finance" : "امور مالی",
        "servicesname" : "نام خدمات",
        "registrationdate" : "تاریخ ثبت :",
        "nextpayment" : "پرداخت بعدی :",
        "billingcycle" : "دوره صورتحساب :",
        "networkinformation": "اطلاعات شبکه",
        "ipaddress": "آدرس آی‌پی :",
        "networkstatus": "وضعیت شبکه :",
        "connected": "متصل",
        "disconnected": "قطع اتصال",
        "login": " اطلاعات حساب کاربری",
        "username": "نام کاربری",
        "password": "رمز عبور",
        "rebootaction": "راه‌اندازی مجدد",
        "stopaction": "خاموش کردن",
        "consoleaction": "کنسول",
        "startaction": "روشن کردن",

        "rebooting": "در حال راه‌اندازی مجدد ...!",
        "stoping": "در حال توقف ...!",
        "consoleing": "در حال یافتن کنسول ...!",
        "starting": "در حال شروع ...!",
        
        "access": "دسترسی",
        "accesstext": "اینجا اطلاعات و ابزارهای مدیریت ماشین مجازی شما قرار دارد.",
        "changeos": "تغییر سیستم‌عامل",
        "network": "شبکه",
        "upgrades": "ارتقاء‌ها",

        "events": "رویدادها",
        "statistics": "آمار",
        "sshkey": "کلید SSH",
        "status": "وضعیت",
        "beginingat": "شروع",
        "endingat": "پایان",
        "completed": "تکمیل شده",

        "cancelled": "لغو شده",
        "loadingmsg": "در حال بارگذاری",
        "loadingmsglong": "در حال تلاش برای دریافت اطلاعات از سرور، ممکن است چند ثانیه طول بکشد.",
        "iplists": "لیست آدرس‌های آی‌پی",
        "gateway": "دروازه",
        "netmask": "نتمسک",
        "orderip": "سفارش آدرس آی‌پی",

        "currentkey": "کلید فعلی: ",
        "upgradecloud": "ارتقاء سرور ابری",
        "setup": "نصب سیستم",
        "waittofetch": "لطفاً صبر کنید، چند ثانیه برای دریافت تمام اطلاعات لازم است ... !",
        "lastactionpending" : "درخواست آخر شما هنوز در حال اجرا است ... !",
        
        "waitforsetup" : "لطفاً منتظر پایان تنظیمات باشید ... !",
        "orderisinstalling" : "ماشین شما در حال نصب",
        "dontclose" : "لطفاً این پنجره را نبندید و منتظر پایان تنظیمات باشید ... !",
        "willtake" : "این ممکن است چند دقیقه طول بکشد",
        "goingtoinstall" : "شما در حال نصب",
        "onyourorder" : "بر روی ماشین‌ هستید!",
        "installationalert" : "در طول نصب، داده‌های شما به طور دائمی حذف خواهند شد.",
        "destroyalert" : "با عمل حذف ماشین، تمامی اطلاعات ماشین به صورت همیشگی پاک می شود",
        "clearandinstall" : "پاک‌سازی و نصب",
        "alert" : "هشدار",
        "installing" : "در حال نصب",

        "installedsuccessfully" : "با موفقیت نصب شد!",
        "accountinformation" : "اینجا اطلاعات حساب شما قرار دارد:",
        "lastaction" : "آخرین عملیات : ",
        "close" : "بستن",
        "thiscommand" : "این دستور ممکن است کمی طول بکشد. لطفاً صبور باشید.",

        "goingto" : "شما در حال ",
        "yourorder" : "بر روی ماشین هستید",
        "requestgetlink" : "شما برای دریافت لینک کنسول درخواست داده اید!",
        "yourcommand" : "دستور شما، ",
        "hasdonesuccessfully" : "با موفقیت انجام شد",
        "accessconsole" : "شما می‌توانید از طریق لینک زیر به کنسول‌تان دسترسی پیدا کنید",
        "openconsole" : "باز کردن کنسول",

        "confirmtext" : "آیا از این اطمینان دارید؟",
        "currentaction" : "عملیات فعلی : ",
        
        "chooselanguage" : "زبان را انتخاب کنید",
        "english" : "انگلیسی",
        "farsi" : "فارسی",
        "turkish" : "ترکی",
        "french" : "فرانسوی",
        "deutsch" : "آلمانی",
        "russian" : "روسی",
        
        "setlanguage" : "تنظیم زبان",
        "traffics" : "اطلاعات ترافیک",
        "buytraffics" : "خرید ترافیک",
        "tabeltraffic" : "حجم ترافیک: ",
        "traffictype" : "نوع ترافیک : ",
        "trafficusage" : "ترافیک مصرف شده: ",
        "trafficdate" : "زمان شروع ترافیک: ",
        "main" : "طرح ترافیک اصلی",
        "plus" : "طرح ترافیک اضافه",
        
        "actionstatuscompleted" : "تکمیل شده",
        "actionstatuspending" : "در انتظار تایید",
        "actionstatusprocessing" : "در حال پردازش",

        "fetchingalert" : "در حال دریافت اطلاعات",
        "nothingeheader" : "متاسفانه!",
        "nothingtoseetext" : "هیچ اطلاعاتی از سرور دریافت نکردیم، هیچ چیزی برای نمایش وجود ندارد!",
        "software" : "نصب نرم‌افزار",
        "install" : "نصب",
        "consolefailed" : "مشکلی با لینک کنسول وجود دارد، لطفاً دوباره تلاش کنید",
        'failed' : 'ناموفق',
        "consoleisrunningalery" : "سیستم در حال یافتن لینک اتصال به کنسول است. این فرایند ممکن است چند دقیقه طول بکشد.",
        "tryagain" : "تلاش مجدد",
        "sshkeytitle" : "کلید SSH : ",
        "suspend" : "تعلیق",
        "unsuspend" : "آزادسازی",
        "refresh" : "طرح به‌روز‌رسان",
        "trafficplan" : "طرح ترافیک",
        "remainingtraffic" : "حجم باقیمانده:",
        "trafficduration" : "مدت زمان طرح:",
        "remainingtime" : "زمان باقیمانده:",
        "failactionmsg" : "آخرین عملیات نتوانسته کامل شود و هنوز در حالت (ناتمام) قرار دارد. لطفا یک بار دیگر برای عملیاتی جدید تلاش کنید",
        "snapshot" : "اسنپ شات",
        "traffic" : "ترافیک",
    // end from Product

    // Unique for this cloud
        "todeleteyourorder" : "برای حذف ماشین‌تان، باید عبارت",
        "writedestroy" : "'destroy'",
        "intheboxbelow" : "را در کادر زیر بنویسید و چند ثانیه منتظر بمانید",
        "typehere" : "عبارت را اینجا تایپ کنید:",
        "failedmessage" : "مشکلی در دریافت اطلاعات از سرور وجود دارد، وضعیت عملیات هنوز ناموفق است!",
        "error" : "خطا",
        "trafficprice" : "قیمت : ",
        "costperhour" : "هزینه ساعتی",
        "cent" : "سنت",
        "$" : "دلار",
        "setupaction": "نصب سیتم عامل",
        "destroying": "در حال حذف ",
        "destroyaction": "حذف",
        "fetching" : "در حال دریافت اطلاعات",
        "payasyougo" : "پرداخت به ازای مصرف",
    // End Unique for this cloud
    
// end order View 
     


// index page
    "clicktoseeadmin" : "مدیریت بالانس کاربر",
    "orderlist": "لیست ماشین‌ها",
    "topup": "افزایش اعتبار",
    "listofactiveorders": "لیست ماشین‌های فعال",
    "noactiveorder": "شما در حال حاضر هیچ ماشین فعالی ندارید.",
    "address": "آدرس",
    "hostnameontable": "نام ماشین",
    "templateontable": "قالب",
    "viewontable": "مشاهده جزییات",
    "statusontable": "وضعیت",

// new charging Module
    "cloudbalance" : "موجودی حساب ابری",
    "actiondidnotsucceed" : "این عمل موفق نشد، لطفاً صفحه را دوباره بارگذاری کرده و مجدداً امتحان کنید",
    "noaccessinvoice" : "دسترسی به ایجاد فاکتور وجود ندارد",
    "noaccesscharge" : "فاکتور با موفقیت ایجاد شده است، اما ما دسترسی به شارژ موجودی شما نداریم. لطفاً دوباره امتحان کنید یا با مدیر خود تماس بگیرید",
    "noaccessapply" : "فاکتور با موفقیت ایجاد شده و ما موجودی ابری شما را شارژ کرده‌ایم، اما ما دسترسی به پرداخت خودکار فاکتور شما نداریم. لطفاً تلاش کنید فاکتور را به صورت دستی پرداخت کنید",
    "reload" : "بارگذاری مجدد",
    "cloudaccount" : "شبکه جهانی ابری",
    "movebalance" : "انتقال موجودی",
    "heretocharge" : "در اینجا می‌توانید موجودی ابری خود را شارژ کنید",
    "yourcredit" : "اعتبار کاربر",
    "isnotenough" : "اعتبار شما کافی نیست، لطفاً ابتدا به حساب خود بروید و کمی اعتبار اضافه کنید",
    "minimumis" : "حداقل اعتبار برای شارژ حساب ابری شما",
    "chargecloudaccount" : "شارژ حساب ابری",
    "youcantransfercredit" : "شما می‌توانید از اعتبار حساب خود برای شارژ حساب ابری خود استفاده کنید. با این عملیات، شما اعتبار حساب خود را به موجودی ابری خود منتقل می‌کنید",
    "pleaseinputamountmoney" : "لطفاً مقداری که می‌خواهید حساب ابری خود را شارژ کنید وارد کنید، به خاطر داشته باشید که حداکثر مقدار مجاز اعتبار شماست",
    "amounttocharge" : "مبلغ شارژ",
    "donthaveenoughcredit" : "شما اعتبار کافی ندارید، لطفاً ابتدا کمی اعتبار اضافه کنید",
    "islessthanminimum" : "اعتبار شما کمتر از حداقل مجاز برای شارژ است. حداقل مقدار",
    "lessthanalowedminimum" : "این عدد وارد شده معتبر نیست، کمتر از حداقل مجاز برای شارژ است. حداقل مقدار",
    "notvaliddecimal" : "این عدد معتبر نیست، از اعشار استفاده نکنید",
    "thisismorethancredit" : "این عدد بیشتر از اعتبار شماست",
    "youraccountcreditis" : "اعتبار حساب شما",
    "andyouaretransfering" : "هست و شما در حال انتقال ",
    "intoyourbalance" : "به موجودی ابری خود هستید",
    "ifyousurealmost" : "اگر اطمینان دارید، لطفاً کلید شروع انتقال را در پایین انتخاب کنید",
    "pleasedontreload" : "لطفاً این صفحه را دوباره بارگذاری نکنید",
    "starttransferring" : "شروع انتقال",
    "step1creatinganinvoice" : "مرحله اول: ایجاد فاکتور",
    "step2chargethecloudaccount" : "مرحله دوم: شارژ حساب ابری",
    "step3payyourinvoice" : "مرحله سوم: پرداخت فاکتور",
    "accountcredit" : "اعتبار حساب",
    "successful" : "موفق",
    "chargingdonesuccessfully" : "عملیات شارژ با موفقیت انجام شده است، لطفاً صفحه را دوباره بارگذاری کنید تا نتیجه را ببینید",
    "currentbalanceautovm" : "بالانس ابری کاربر",
    "addorremove" : "افزایش یا کاهش ±",
    "increase" : "افزایش",
    "decrease" : "کاهش",
    "transid" : "شماره تراکنش",
    "hasrecordedsuccessfully" : "با موفقیت ثبت شد",
    "anerroroccurred" : "خطایی روی داده است",
    "cannotfinduserid" : "آی دی کاربر یافت نشد",
    "useminnuestoreduce" : "برای کاهش بالانس از علامت منفی استفاده کنید",
    "ittakesminutes" : "برای اعمال تراکنش در بالانس مشتری بیشتر از ۳۰ ثانیه زمان انتظار لازم است",
    "adjustusebalance" : "مدیریت بالانس کاربر",
    "maketransaction" : "ثبت تراکنش",
    "email" : "پست الکترونیک",
    "userdetailautovm" : "اطلاعات کاربر",
    "taketimetoseeresult" : "زمان تقریبی برای اعمال تراکنش در موجودی حساب ابری بیشتر از ۳۰ ثانیه است",
    "noaction" : "بدون متد",
// end index
    



// create order page
    "backtoorderlist" : "بازگشت به لیست ماشین‌ها",
    "datacenters" : "مراکز داده",
    "locationlist" : "کشور",
    "chooseregion" : "انتخاب منطقه جغرافیایی قرارگیری مرکز داده",
    "products" : "پلن های",
    "selectaproduct" : "یک محصول از این منطقه انتخاب کنید",
    "thereisnodatacenter" : "در منطقه‌ای که انتخاب کرده‌اید محصولی وجود ندارد",
    "pleaseselect" : "لطفاً ابتدا یک مرکز داده را از لیست بالا انتخاب کنید",
    "bandwidth" : "پهنای باند: ",
    "operationsystem" : "سیستم‌عامل *",
    "selectatemplate" : "یک قالب انتخاب کنید",
    "nameofhost" : "نام ماشین *",
    "enteraname" : "یک نام برای ماشین مجازی وارد کنید",
    "Addssh" : "افزودن کلید عمومی SSH",
    "extraresource" : "منابع مازاد",
    "orderextra" : "شما می‌توانید منابع مازاد را بر اساس نیازهای خود سفارش دهید",
    "totalcost" : "هزینه کل ",
    "totalcostis" : "هزینه کل ایجاد ماشین ",
    "firstselectone": "لطفاً ابتدا یکی از محصولات بالا را انتخاب کنید",
    "createorder" : "ایجاد ماشین",
    "hourly" : "ساعتی",
    "cancel": "لغو",
    "createthisorder": "ایجاد این ماشین",
    "youarecreating" : "شما در حال ایجاد ماشین با تنظیمات زیر هستید!",
    "makesure" : "اطمینان حاصل کنید که تمام اطلاعات مورد نیاز را درج کرده باشید",
    "notprovideallinformation" : "شما تمامی اطلاعات مورد نیاز را وارد یا انتخاب نکرده اید!",
    "datacentermissed" : "مرکز داده انتخاب نشده است",
    "productmissed" : "محصول مشخصی انتخاب نشده است",
    "templatemissed" : "قالب ماشین انتخاب نشده است",
    "allinfoprovided" : "تمامی اطلاعات فراهم شده است",
    "name" : "نام",
    "datacenter" : "مرکز داده: ",
    "product" : "محصول: ",
    "producttemplate" : "قالب",
    "sshkeytitle" : "کلید SSH : ",
    "price" : "قیمت : ",
    "monthly" : "ماهیانه",
    "youdidntchoose" : "هیچ پیکربندی‌ای را انتخاب نکرده‌اید",
    "entersshkey" : "کلید را وارد کنید",
    "required" : "ضروری",
    "balance" : "موجودی کیف پول",
    "orderlink": "مشاهده ماشین",
    "ordercreatesuccessfully": "ماشین با موفقیت ایجاد شد!",
    "currentplan" : "هزینه سرویس",
    "createorderfailed" : "متاسفانه ساخت این ماشین با خطا مواجه شده است. لطفا دوباره تلاش کنید. اگر این خطا دوباره روی داد، لطفا با پشتیبانی تماس بگیرید.",
    "createanotherorder" : "ساخت یک ماشین دیگر",
    "createsuccessmsg": "شما می توانید از طریق لینک زیر ماشین خود را مشاهده کنید. همینطور می توانید یک ماشین دیگر سفارش دهید.",
    "onlyenglishletters": "فقط حروف انگلیسی قابل قبول است",

    "cpucore" : "هسته پردازنده",
    "cpufrequency" : "فرکانس پردازنده",
    "configuration" : "پیکربندی",
    "configinyourfavor" : "این محصول را بر اساس نیاز خود پیکربندی کنید",
    "pleaseselectaplan" : "لطفاً ابتدا یک مصحول را از لیست بالا انتخاب کنید",
    "balanceisnotenough" : "موجودی حساب ابری شما برای ساخت ماشین کافی نیست، برای ادامه نیاز هست که حساب خود را شارژ کنید",
    "billsummary" : "خلاصه صورتحساب",
    "seeyourorderdetails" : "جزئیات سفارش و هزینه‌ها را ببینید",
    "costoneip" : "هزینه هر آدرس آی‌پی",
    "costonegigtraffic" : "هزینه هر گیگ ترافیک",
    "freeprice" : "رایگان",
    "pricestartsfrom" : "شروع قیمت از ",
    "confirmationtext" : "قوانین را مطالعه کرده و با شرایط و قوانین موافقت می‌کنم",
    "optional" : "اختیاری",
    "readmore" : "مطالعه بیشتر ...",

    "nanoconfiguration" : "پیکره‌بندی نانو",
    "basicconfiguration" : "پیکره‌بندی پایه",
    "standardconfiguration" : "پیکره‌بندی استاندارد",
    "advancedconfiguration" : "پیکره‌بندی پیشرفته",
    "enterpriseconfiguration" : "پیکره‌بندی اینترپرایز",
    "ipv" : "انتخاب نسخه پروتکل",
    "ipvversion4" : "نسخه چهار",
    "ipvversion6" : "نسخه شش",
    "IPV6" : "آی‌پی نسخه ۶ : ",
    "Create Machine" : "ساخت ماشین",
    "Machine View" : "صفحه نمایش",
// create order page


// admin panel
    "usertoken" : "توکن کاربر",

    

    // new CAASIFY
    "Locations" : "موقعیت جغرافیایی",
    "in" : " ",
    "machinecreatesuccessfully" : "ماشین با موفقیت ساخته شد",
    "createanothermachine" : "ساخت یک ماشین",
    "ID" : "شناسه",
    "Alive" : "کارکرد",
    "Price" : "قیمت",
    "Views" : "مشاهده",
    "Order is Loading" : "جزییات سفارش در حال پردازش است",
    "This Order has been deleted" : "این سفارش حذف شده است",
    "Product Price" : "هزینه سرویس",
    "Action" : "رویداد",
    "Time" : "زمان رویداد",
    "Controllers Are Loading" : "کنترلرها در حال بارگذاری",
    "Views Are Loading" : "ویوها در حال بارگذاری",
    "No valid Controller Founded" : "هیچ کنترلری پیدا نشد",
    "Confirmation" : "تاییدیه",
    "You are going to" : "شما در حال ",
    "your machine, are you sure ?" : " کردن ماشین هستید، آیا مطمئن هستید؟",
    "Something is in queue !" : "عملیات دیگری در حال انجام است. لطفا صبر کنید",
    


    "Graphs" : "نمودارها",
    "BackUp" : "پشتیبان گیری",
    "Volume" : "حجم",
    "Resize" : "تغییر پلن",
    "Setting" : "تنظیمات",
    "History" : "تاریخچه",

    "SETUP" : "نصب سیستم",
    "START" : "روشن",
    "STOP" : "خاموش",
    "REBOOT" : "ریبوت",
    "DELETE" : "حذف",
    "SHOW" : "نمایش",
    
    "DELIVERED" : "ارسال موفق",
    "FAILED" : "خطای ارسال",
    "PENDING" : "در حال پردازش",
    "Marketplace" : "بازارچه",
    "createmachinefailed" : "ساخت ماشین با مشکل مواجه شده است",
    "Warning" : "اخطار",

    "MoreThanMax" : "این مقدار از حداکثر مبلغ اجازه شارژ بیشتر است",    
    "DeleteIsNotAllowed" : "در حالت دمو، اجازه حذف ماشین را ندارید",    
    "TrafficAlert" : "ممکن است زمان زیادی طول بکشد",    
    "Machine Info" : "اطلاعات ماشین",
    
    
    
    
    
    

    "Cloud Account" : "سرور ابری",
    "InsertValidNumber" : "جهت افزایش موجودی، لطفا مبلغ مورد نظر را وارد کنید",
    "Creating invoice" : "در حال صدور فاکتور",
    "invoice created successfully" : "فاکتور با موفقیت صادر شد",
    "Go to invoice payment" : "پرداخت فاکتور",
    "Creating invoice Failed, try again" : "خطا در صدور فاکتور، مجدد تلاش کنید",
    "Inbound" : "ترافیک ورودی",
    "Outbound" : "ترافیک خروجی",
    "Admin Finance" : "امور مالی ریسلر",
    "AdminBalance" : "بالانس ریسلر (یورو)",
    "Commission" : "کمیسیون",
    "User Finance" : "امور مالی کاربر",
    "UserBalanceReal" : "بالانس کاربر (یورو)",
    "UserBalanceWithCommission" : "بالانس کاربر بعلاوه کمیسیون (یورو)",
    "Charging" : "ثبت تراکنش",
    "With Commission" : "با کمیسیون",
    "Increase User Balance" : "افزایش موجودی",
    "Decrease User Balance" : "کاهش موجودی",
    "Commission is Wrong" : "کمیسیون اشتباه است",
    "User Orders" : "سفارشات کاربر",
    "User has no active order" : "کاربر هیچ سفارش فعالی ندارد",
    "Error 670: call your admin" : "خطای ۶۷۰: کمیسیون اشتباه وارد شده است ",
    "increasebalance" : " شما در حال افزایش بالانس کاربر هستید",
    "decreasebalance" : " شما در حال کاهش بالانس کاربر هستید", 
    "It is not valid number" : "این مقدار معتبر نیست",
    "ChargingUserFor" : "افزایش بالانس به میزان",
    "DeChargingUserFor" : "کاهش بالانس به میزان",
    "Charge action has done Successfully" : "افزایش بالانس با موفقیت انجام شد",
    "headcharge" : "تغییر بالانس کاربر",
    "euro" : " یورو ",
    "amounttochargewithcommission" : "مبلغ شارژ بعلاوه کمیسیون (یورو)",
    "amounttochargereal" : "مبلغ شارژ واقعی (یورو)",
    "doTransaction" : "ثبت تراکنش",

    "BalanceIsLow" : "اعتبار اکانت کلاد شما بسیار کم است",
    "MachienWouldDelete" : "ماشین شما ممکن است حذف شود و اطلاعات شما پاک شود",
    "hours or less" : "(مدت باقی مانده کمتر از یک ساعت است)",
    "an hour or less" : "(مدت باقی مانده یک ساعت یا کمتر است)",
    "24 hours or less" : "(مدت باقی مانده، کمتر از ۲۴ ساعت است)",
    "I am aware of the Risk" : "از ریسک این اعلان آگاهم",
    "Confirm Alert and Close" : "تایید اعلان",


    "SpotAlert01" : "Attention: Spot VMs are designed for temporary, flexible workloads and should not be used for critical or production environments.",
    "SpotAlert01" : "توجه: محصولات اسپات برای مصارف کوتاه مدت، محیط توسعه مناسب است ولی برای کاربرد بلند مدت و پایدار نباید استفاده شود",
    "SpotAlert02" : "مهمترین موارد قابل توجه:",
    "SpotAlert03" : "ریسک پیشگیرانه:",
    "SpotAlert04" : "ماشین‌های مجازی اسپات ممکن است در هر زمان که ظرفیت در جای دیگر نیاز باشد، توسط ارائه‌دهنده آن پیشگیری (حذف) شود",
    "SpotAlert05" : "بدون گارانتی:",
    "SpotAlert06" : "هیچ تضمینی برای دسترسی در لحظه یا اپتایم به ماشین‌های مجازی اسپات وجود ندارد",
    "SpotAlert07" : "بهترین کاربرد:",
    "SpotAlert08" : "ماشین های اسپات برای پردازش دسته‌ای، محیط توسعه، انجام تست و سایر کاری بدون نیاز به تضمین مناسب هستند",
    "SpotAlert09" : "برای داشتن ثبات و بهترین کیفیت پیشنهاد می شود از مواری غیر اسپات استفاده کنید",
    

}

const words = {
    ...messages,
    ...common,
    ...errors
}
