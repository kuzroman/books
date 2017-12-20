require("../css/main.scss"); // разобраться можно ли указывать путь не здесь а в webpack

require('parsleyjs'); // validate

require("./common.js");
require("./repo/sign/signup.js"); // разобраться как вынести в отдельный модуль, но без зависимостей бибилотек!

require("./repo/translate/main.js");