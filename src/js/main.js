require("../css/main.scss"); // разобраться можно ли указывать путь не здесь а в webpack

require('parsleyjs'); // validate

require("./common.js");

// разобраться как вынести в отдельный модуль, но без зависимостей бибилотек!
require("./repo/sign/sign_up.js");
require("./repo/sign/sign_in.js");
// ----------

require("./repo/translate/main.js");