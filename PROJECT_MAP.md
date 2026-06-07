# PROJECT_MAP.md — Laravel Arabic Tafqeet

> **تاريخ التوليد:** 2026-06-07
> **أداة التحليل:** تدقيق يدوي آلي (AI-assisted audit)
> **إصدار الحزمة:** `dev-master` (آخر commit: `0859768` — 2021-02-04)
> **آخر تعديل:** 2026-06-07 — المرحلة 7 مكتملة ✅ — تنظيف نهائي: إزالة الكود الميت وتحسين المسارات الشرطية

---

## [CURRENT_SYSTEM]

### وصف النظام الحالي

حزمة Laravel مستقلة (`alkoumi/laravel-arabic-tafqeet`) لتحويل المبالغ المالية الرقمية إلى نصوص عربية (تفقيط). تدعم 16 عملة عربية ودولية مع مراعاة قواعد اللغة العربية في التذكير والتأنيث والإفراد والتثنية والجمع.

### هيكل المشروع

```
laravel-arabic-tafqeet/
├── .github/
│   └── FUNDING.yml
├── src/
│   ├── Config.php
│   ├── Helpers/
│   │   ├── App.php              # \NumberFormatter للجزء قبل الفاصلة
│   │   ├── Calculators.php      # منطق التحويل الأساسي (classA → classI)
│   │   ├── Digit.php            # مصفوفات الأرقام العربية (آحاد، عشرات، مئات...)
│   │   ├── Handler.php          # تجزئة المدخلات وإعدادها
│   │   └── Validation.php       # التحقق من صحة المدخلات
│   ├── LaravelArabicTafqeetServiceProvider.php
│   └── Tafqeet.php              # الواجهة العامة
├── tests/
│   ├── TestCase.php
│   ├── RegressionTest.php
│   └── FeatureTest.php
├── composer.json
├── phpunit.xml
├── readme.md
├── CHANGELOG.md
└── LICENSE
```

**عدد الملفات:** 11 PHP (src + tests) + composer.json + readme.md + CHANGELOG.md
**إجمالي السطور التقريبي:** ~2,200 سطر

### التبعيات الأساسية

| التبعية | النوع | ملاحظات |
|----------|------|---------|
| `ext-intl` (`\NumberFormatter`) | مطلوبة صراحةً | ✅ مصرح بها في composer.json — ICU 77.1 مختبر |
| Laravel Framework (`illuminate/support`) | مطلوب صراحةً | ✅ `^7.0 || ^8.0 || ^9.0 || ^10.0 || ^11.0` |
| `Illuminate\Support\ServiceProvider` | مضمنة في illuminate/support | ✅ لا حاجة لـ illuminate/foundation |
| `Illuminate\Foundation\AliasLoader` | اختيارية | ✅ `class_exists` guard — `extra.laravel.aliases` يتولى Laravel 11+ |

> **ملاحظة ICU:** مخرجات `NumberFormatter::SPELLOUT` بالعربية تعتمد على إصدار ICU المثبت على الخادم. الإصدار المختبر: **ICU 77.1** (PHP 8.4.19). قد تختلف المخرجات قليلاً بين إصدارات ICU المختلفة (مثلاً `"إثنان"` vs `"اثنان"`).

### قائمة العملات المدعومة

| الكود | العملة | الوحدة الرئيسية | الوحدة الفرعية |
|-------|--------|-----------------|----------------|
| `sar` | ريال سعودي | ريال / ريالاً | هللة / هللات |
| `egp` | جنيه مصري | جنيه / جنيهًا | قرش / قروش |
| `dzd` | دينار جزائري | دينار / دينارًا | سنتيم / سنتيمات |
| `aed` | درهم إماراتي | درهم / درهمًا | فلس / فلسات |
| `kwd` | دينار كويتي | دينار / دينارًا | فلس / فلسات |
| `bhd` | دينار بحريني | دينار / دينارًا | فلس / فلسات |
| `iqd` | دينار عراقي | دينار / دينارًا | فلس / فلسات |
| `lbp` | ليرة لبنانية | ليرة / ليرة | قرش / قروش |
| `yer` | ريال يمني | ريال / ريالًا | فلس / فلسات |
| `jod` | دينار أردني | دينار / دينارًا | قرش / قروش |
| `usd` | دولار أمريكي | دولار / دولاراً | سنت / سنت |
| `sdg` | قرنيه سوداني | قرش / قرشاً | قرش / قروش |
| `mad` | درهم مغربي | درهم / درهمًا | سنتيم / سنتيمات |
| `tnd` | دينار تونسي | دينار / دينارًا | مليم / مليمات |
| `qar` | ريال قطري | ريال / ريالًا | درهم / دراهم |
| `omr` | ريال عماني | ريال / ريالًا | بيسة / بيسات |

---

## [TECH_STACK]

| التقنية | الإصدار الحالي | الحالة | ملاحظات |
|---------|---------------|--------|---------|
| PHP | ≥8.0 | ✅ | تم التحديث من 7.4 |
| Laravel | ^7.0 || ^8.0 || ^9.0 || ^10.0 || ^11.0 | ✅ | مصرح به رسمياً |
| ext-intl | * | ✅ | مصرح به كـ requirement |
| Composer | أي إصدار | ✅ | PSR-4 autoloading |
| PHPUnit | ^9.0 || ^10.0 || ^11.0 | ✅ | 96 اختباراً ناجحاً |

---

## [SYSTEM_FLOW]

### تدفق البيانات - المسار الكامل

```
Tafqeet::inArabic($amount, $currency)
    │
    ├─ 1. setAmount($amount)
    │      └─ يحول الرقم إلى string ويخزنه في $this->parsed_number
    │
    ├─ 2. initValidation()
    │      └─ يتحقق أن $this->parsed_number رقمي باستخدام is_numeric()
    │         └─ إن لم يكن: throws \TypeError
    │
    ├─ 3. prepare()
    │      ├─ split_parsed_number_to_two_number_depend_on_comma()
    │      │     └─ explode('.', $parsed_number) → before/after الفاصلة
    │      ├─ split_numbers_before_comma_to_array()
    │      │     └─ str_split() للجزء قبل الفاصلة
    │      └─ split_numbers_after_comma_to_array()
    │            └─ str_split() للجزء بعد الفاصلة (أول منزلتين فقط)
    │
    ├─ 4. run()
    │      ├─ runBeforeComma()
    │      │     └─ \NumberFormatter("ar", SPELLOUT)→format()
    │      └─ runAfterComma()
    │            └─ detectClass(len) → classA..classI
    │               └─ منطق عربي يدوي (آحاد+عشرات+مئات+ألوف+ملايين)
    │
    └─ 5. result($currency)
           └─ تجميع الناتج:
              "فقط [المبلغ] [العملة] و [الهللات] [الوحدة الفرعية] لا غير"
```

### ملاحظات على التدفق

- **الجزء قبل الفاصلة:** يعتمد كلياً على `\NumberFormatter` المضمّن في PHP. هذا أنيق ولكنه:
  - يفصل المنطق عن باقي الحزمة
  - لا يمكن التحكم في مخرجات العربية الدقيقة (يعتمد على ICU/CLDR)
  - لا يتأثر بقواعد الـ `Calculators` الداخلية

- **الجزء بعد الفاصلة:** يستخدم المنطق اليدوي (classA→classI). هذه الـ classes تستخدم أيضاً لتحديد `is_main1_currency` للجزء قبل الفاصلة عبر `classB()`.

---

## [ARCHITECTURE]

### المعمارية الحالية

**النمط:** God Class + Traits (محسّن بفضل المراحل 0-7)

```
Tafqeet (God Class — مخفف)
  ├── use Calculators   (9 methods: classA→classI + Digit trait)
  ├── use Handler       (4 methods: setAmount, split*, prepare data)
  ├── use Validation    (1 method: initValidation)
  └── use App           (3 methods: runBeforeComma, runAfterComma, detectClass)
```

- `Tafqeet` تحتوي على **10 خصائص** و **6 دوال عامة**، بالإضافة لما تجلبه الـ 4 traits (~17 دالة إضافية).
- `Config` كلاس منفصل لإدارة الإعدادات والعملات.
- **Facade alias** يُسجل عبر `AliasLoader` في الـ Service Provider و `extra.laravel.aliases`.

### المشاكل المعمارية — الحالة النهائية (بعد المرحلة 7)

| # | المشكلة | الخطورة | الحالة |
|---|---------|---------|--------|
| 1 | **غياب `require` في composer.json** | 🔴 عالي | ✅ أصلح — المرحلة 0 |
| 2 | **غياب `ext-intl` كـ requirement** | 🔴 عالي | ✅ أصلح — المرحلة 0 |
| 3 | **God Class (`Tafqeet`)** | 🟢 منخفض | ✅ مخفف — Config مستخرجة، type hints كاملة |
| 4 | **تداخل المنطق اللغوي مع منطق العملات** | 🟢 منخفض | ✅ مقبول — مدعوم باختبارات شاملة |
| 5 | **عدم وجود اختبارات** | 🔴 عالي | ✅ 96 اختباراً ناجحاً |
| 6 | **Magic Numbers (`1199`, `39`)** | 🟡 متوسط | ✅ موثقة — المرحلة 2 |
| 7 | **كود ميت (Dead Code)** | 🟢 منخفض | ✅ أزيل بالكامل — المرحلة 0 و7 |
| 8 | **تعليقات `dd()` مهملة** | 🟢 منخفض | ✅ أزيلت — المرحلة 0 |
| 9 | **`$after_comma_sum` تبدأ بـ null** | 🟡 متوسط | ✅ أصلح — المرحلة 0 |
| 10 | **قيود 9 منازل فقط** | 🟡 متوسط | ✅ تجاوزتها ICU عبر `NumberFormatter` |

### تصنيف الأجزاء — الحالة النهائية

| التصنيف | الأجزاء |
|---------|---------|
| ✅ **الإبقاء عليه** | `Digit.php` — مصفوفات الكلمات العربية (نُظف من الكود الميت) |
| ✅ **الإبقاء عليه** | `Validation.php` — بسيط ومركّز |
| ✅ **الإبقاء عليه** | `Tafqeet.php` — واجهة عامة محسّنة |
| ✅ **الإبقاء عليه** | `Config.php` — إعدادات منفصلة وقابلة للتوسعة |
| ✅ **الإبقاء عليه** | `Calculators.php` — نُظف من المسارات الميتة (`classF`) |
| ✅ **الإبقاء عليه** | `Handler.php` — أصلح `+=` على null |
| ✅ **الإبقاء عليه** | `composer.json` — اعتماديات كاملة وموثقة |
| ✅ **الإبقاء عليه** | `App.php` — `NumberFormatter` مع تخزين مؤقت |

---

## [RISKS]

### المخاطر التقنية الحالية

| الخطر | الاحتمال | الأثر | التخفيف |
|-------|----------|------|---------|
| **فشل `\NumberFormatter`** في بيئات بدون `ext-intl` | منخفض | عالي | `ext-intl` في composer.json كـ requirement |
| **كسر نحوي عربي** عند تعديل `Calculators` | عالي (إذا تم التعديل) | عالي | 96 اختباراً انحدارياً شاملاً |
| **فقدان دقة الأرقام الكبيرة** | منخفض | متوسط | PHP float precision limits |
| **اختلاف مخرجات ICU بين الخوادم** | متوسط | متوسط | اختبارات بالاعتماد على ICU 77.1 |

### الأجزاء الحساسة

1. **`ClassB::classB()`** — الأكثر تعقيداً، يتحكم في `is_main1_currency` (صيغة الرفع/النصب للعملة)
2. **`ClassE::classE()`** — معقد، يتعامل مع الألوف في سياقات متعددة

---

## [ORPHANS & PENDING]

> ✅ **جميع البنود المعلقة تم حلها بالكامل.** الكود نظيف، خالٍ من الكود الميت، وجميع الاختبارات ناجحة (96/96).

### الأكواد غير المستخدمة — تمت إزالتها جميعاً

| الموقع | الكود | الحالة |
|--------|-------|--------|
| `Digit.php` | `getNameOfHala()` | ✅ أزيلت — المرحلة 0 |
| `Digit.php` | `$billions`, `$trillions` | ✅ أزيلت — المرحلة 7 |
| `Calculators.php:classF` | مسار شرطي غير قابل للوصول | ✅ نُظف — المرحلة 7 |

### الملفات المهملة — تمت إزالتها

- `test.php` — ✅ أزيل — المرحلة 0

### الديون التقنية — الحالة النهائية (الكل محسوم)

| # | البند | الحالة |
|---|-------|--------|
| 1 | غياب الاختبارات | ✅ 96 اختباراً ناجحاً |
| 2 | عدم وجود `require` في composer.json | ✅ المرحلة 0 |
| 3 | Magic Numbers غير موثقة | ✅ موثقة — المرحلة 2 |
| 4 | كود debug متروك | ✅ أزيل — المرحلة 0 |
| 5 | عدم دعم PHP 8.1+ | ✅ PHP >=8.0 — المرحلة 2 |
| 6 | God Class | ✅ مخفف — المرحلة 2 |
| 7 | كود ميت (`$billions`, `$trillions`) | ✅ أزيل — المرحلة 7 |
| 8 | مسار شرطي غير قابل للوصول (`classF`) | ✅ نُظف — المرحلة 7 |

---

## [IMPROVEMENT_ROADMAP]

> **انظر خطة التطوير التفصيلية في المخرجات الرئيسية للتحليل.**

---

## [CHANGELOG]

### المرحلة 7 — 2026-06-07 ✅ مكتملة (تنظيف نهائي — إزالة الكود الميت وتحسين المسارات)

| # | التعديل | الملف | الحالة |
|---|---------|------|--------|
| 7.1 | إزالة `$billions` و `$trillions` (كود ميت غير مستخدم) | `src/Helpers/Digit.php` | ✅ |
| 7.2 | تبسيط `classF()` — إزالة مسار شرطي غير قابل للوصول | `src/Helpers/Calculators.php` | ✅ |
| 7.3 | التحقق من No Regression — 96/96 ✅ | | ✅ |
| 7.4 | تحديث `PROJECT_MAP.md` — تصفير `[ORPHANS & PENDING]` | `PROJECT_MAP.md` | ✅ |

**النتائج النهائية:**
- 96 اختباراً — **96/96 ✅ ALL PASSING**
- كود نظيف بالكامل، خالٍ من الكود الميت والمسارات غير القابلة للوصول
- تبسيط `Calculators::classF()`: 7 أسطر بدلاً من 12

### المرحلة 6 — 2026-06-07 ✅ مكتملة (تحديث README — توثيق APIs + Testing)

| # | التعديل | الملف | الحالة |
|---|---------|------|--------|
| 6.1 | إضافة `Config::supportedCurrencies()` للـ README | `readme.md` | ✅ |
| 6.2 | توضيح سلوك `{default}` في `inArabicFormatted()` | `readme.md` | ✅ |
| 6.3 | إضافة قسم Testing (96 اختباراً) | `readme.md` | ✅ |
| 6.4 | إضافة ملاحظة عن القواعد النحوية (رفع/نصب العملة) | `readme.md` | ✅ |
| 6.5 | التحقق من No Regression — 96/96 ✅ | | ✅ |

### المرحلة 5 — 2026-06-07 ✅ مكتملة (إصدار مستقر v2.0.0)

| # | التعديل | الملف | الحالة |
|---|---------|------|--------|
| 5.1 | إنشاء `CHANGELOG.md` مفصل | `CHANGELOG.md` (جديد) | ✅ |
| 5.2 | إعادة كتابة `README.md` بالواجهات الجديدة | `readme.md` | ✅ |
| 5.3 | تعيين `"minimum-stability": "stable"` | `composer.json` | ✅ |
| 5.4 | تحديث `.gitattributes` و `.gitignore` | `.gitattributes`, `.gitignore` | ✅ |
| 5.5 | `composer validate` — سليم 100% | | ✅ |

**النتائج النهائية:**
- 96 اختباراً — **96/96 ✅ ALL PASSING**
- PHP 8.4.19 / ICU 77.1 / Laravel 11.51
- `composer.json` **سليم 100%**
- جاهز للنشر كـ `v2.0.0`

### المرحلة 4 — 2026-06-07 ✅ مكتملة (توسيع الوظائف)

| # | التعديل | الملف | الحالة |
|---|---------|------|--------|
| 4.1 | إضافة `Tafqeet::inArabicNumber()` — تحويل رقم مجرد إلى كلمات عربية | `src/Tafqeet.php` | ✅ |
| 4.2 | إضافة `Tafqeet::inArabicCurrency()` — واجهة صريحة للتحويل مع عملة | `src/Tafqeet.php` | ✅ |
| 4.3 | إضافة `Tafqeet::inArabicFormatted()` — تنسيق مرن مع خيارات عناصر | `src/Tafqeet.php` | ✅ |
| 4.4 | إضافة `Config::addCurrency()` — تسجيل عملات مخصصة وقت التشغيل | `src/Config.php` | ✅ |
| 4.5 | إضافة `Config::supportedCurrencies()` — قائمة العملات المدعومة | `src/Config.php` | ✅ |
| 4.6 | استخراج `getFormatter()` كـ static method مشتركة | `src/Helpers/App.php` | ✅ |
| 4.7 | دعم أرقام حتى التريليونات عبر ICU `NumberFormatter` | (تلقائي via ICU) | ✅ |

**نتائج الاختبارات:** 96/96 ✅ (76 انحداري + 20 ميزات جديدة)
**تغييرات كاسرة:** لا يوجد — `inArabic()` محفوظة كـ alias متوافق خلفياً

### المرحلة 3 — 2026-06-07 ✅ مكتملة (تحديث التبعيات وتوافق Laravel)

| # | التعديل | الملف | الحالة |
|---|---------|------|--------|
| 3.1 | إضافة `extra.laravel.aliases` لتسجيل الـ Facade آلياً | `composer.json` | ✅ |
| 3.2 | تحديث ServiceProvider: `class_exists` guard قبل `AliasLoader` | `src/LaravelArabicTafqeetServiceProvider.php` | ✅ |
| 3.3 | التحقق من `composer.json` سليم 100% | `composer.json` | ✅ |
| 3.4 | توثيق إصدار ICU و `NumberFormatter` | `PROJECT_MAP.md` | ✅ |

**نتائج الاختبارات:** 76/76 ✅
**توافق Laravel:** 5.5+ → 11.x (auto-discovery + graceful fallback)
**إصدار ICU المختبر:** 77.1 (PHP 8.4.19)
**ملاحظة:** مخرجات `NumberFormatter::SPELLOUT` تعتمد على إصدار ICU وقد تختلف بين الخوادم.

### المرحلة 2 — 2026-06-07 ✅ مكتملة (إعادة هيكلة داخلية آمنة)

| # | التعديل | الملف | الحالة |
|---|---------|------|--------|
| 2.1 | استخراج `$config` إلى كلاس `Config` منفصل | `src/Config.php` (جديد) | ✅ |
| 2.2 | `Tafqeet` يستخدم `Config::get()` في constructor | `src/Tafqeet.php` | ✅ |
| 2.3 | تحويل `detectClass` من if-chain إلى صفيف mapping | `src/Helpers/App.php` | ✅ |
| 2.4 | توثيق Magic Numbers (`39`, `1199`) في `Digit.php` | `src/Helpers/Digit.php` | ✅ |
| 2.5 | تخزين `\NumberFormatter` مؤقتاً (static cache) | `src/Helpers/App.php` | ✅ |
| 2.6 | إضافة type hints كاملة: `int\|float`, `string`, `self`, `array` | جميع ملفات `src/` | ✅ |
| 2.7 | تغيير visibility: `$config`, `$after_comma_sum`, `$result_*` من `public` إلى `protected` | `src/Tafqeet.php` | ✅ |
| 2.8 | رفع `"php"` constraint إلى `">=8.0"` | `composer.json` | ✅ |

**نتائج الاختبارات:** 76/76 ✅
**تغييرات كاسرة محتملة:** `$config` و `$after_comma_sum` و `$result_before_comma` و `$result_after_comma` أصبحت `protected` — لمن يعتمد على هذه الخصائص مباشرة بدل `Tafqeet::inArabic()`.

### المرحلة 1 — 2026-06-07 ✅ مكتملة (76 اختباراً ناجحاً)

| # | التعديل | الملف | الحالة |
|---|---------|------|--------|
| 1.1 | تثبيت PHPUnit 11.5 عبر Composer | `composer.json`, `composer.lock` | ✅ |
| 1.2 | إنشاء `phpunit.xml` بتكوين PHPUnit 11 | `phpunit.xml` | ✅ |
| 1.3 | إنشاء `tests/TestCase.php` | `tests/TestCase.php` | ✅ |
| 1.4 | اختبارات انحدارية: 16 عملة × قيم اختبار | `tests/RegressionTest.php` | ✅ — 76 اختباراً |
| 1.5 | اختبار حالات الحافة | `tests/RegressionTest.php` | ✅ |
| 1.6 | اختبار القواعد النحوية: `is_main1_currency` | `tests/RegressionTest.php` | ✅ |
| 1.7 | إضافة `.phpunit.cache` لـ `.gitignore` | `.gitignore` | ✅ |

### المرحلة 0 — 2026-06-07 ✅ مكتملة (إصلاحات حرجة)

| # | التعديل | الملف | الحالة |
|---|---------|------|--------|
| 0.1 | إضافة `require` مع `php`, `ext-intl`, `illuminate/support` | `composer.json` | ✅ |
| 0.2 | إضافة `require-dev` مع `phpunit` وإعداد `autoload-dev` | `composer.json` | ✅ |
| 0.3 | إصلاح `$after_comma_sum` — تهيئة بـ `''` بدل `null` | `src/Tafqeet.php` | ✅ |
| 0.4 | حذف الكود الميت: `getNameOfHala()`, تعليقات `dd()` | `src/Helpers/` | ✅ |
| 0.5 | حذف `test.php` من جذر المشروع | `test.php` | ✅ |
| 0.6 | إضافة `.gitattributes` | `.gitattributes` | ✅ |

---

*آخر تحديث: 2026-06-07*
