var multilang;

function onLoad() {
	multilang = new MultiLang('lang/languages.json', 'en', this.initList);
}

function langChange(sel) {
	multilang.setLanguage(sel);
	refreshLabels();
}

function initList() {
	var list = document.getElementsByName("listlanguages")[0];
	list.options.length = 0;

	for (var key in multilang.phrases) {
		var lang = document.createElement("option");
		lang.value = key;
		lang.innerHTML = multilang.phrases[key]['langdesc'];
		list.appendChild(lang);
	}

	refreshLabels();
}

function refreshLabels() {
	var allnodes = document.body.getElementsByTagName("*");
	for (var i=0, max=allnodes.length; i < max; i++) {
		var idname = allnodes[i].id;
		if (idname != '') {
			allnodes[i].textContent = multilang.get(idname);
		};
	};
}