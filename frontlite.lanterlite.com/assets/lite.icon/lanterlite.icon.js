
var I = new Icon()
function Icon() {
	this.obj = new obj()
	this.rocket = '🚀'
	this.sound = "&#9834;"
	this.bracket_left = "&#10100;"
	this.bracket_right = "&#10101;"
	this.double_quotation1 = "&#10078;"
	this.double_quotation2 = "&#10077;"
	this.single_quotation1 = "&#10076;"
	this.single_quotation2 = "&#10075;"
	this.heart = "&#10084;"
	this.arrow_bottom_right = "&#10164;"
	this.arrow_right = "&#10165;"
	this.arrow_top_right = "&#10166;"

	function obj() {
		this.rocket = '<svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="rocket" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="svg-inline--fa fa-rocket fa-w-16 fa-lg"><path fill="currentColor" d="M505.05 19.1a15.89 15.89 0 0 0-12.2-12.2C460.65 0 435.46 0 410.36 0c-103.2 0-165.1 55.2-211.29 128H94.87A48 48 0 0 0 52 154.49l-49.42 98.8A24 24 0 0 0 24.07 288h103.77l-22.47 22.47a32 32 0 0 0 0 45.25l50.9 50.91a32 32 0 0 0 45.26 0L224 384.16V488a24 24 0 0 0 34.7 21.49l98.7-49.39a47.91 47.91 0 0 0 26.5-42.9V312.79c72.59-46.3 128-108.4 128-211.09.1-25.2.1-50.4-6.85-82.6zM384 168a40 40 0 1 1 40-40 40 40 0 0 1-40 40z" class=""></path></svg>'
		this.heart = '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="1em" height="1em" style="-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 20 20"><path d="M10 17.12c3.33-1.4 5.74-3.79 7.04-6.21 1.28-2.41 1.46-4.81.32-6.25-1.03-1.29-2.37-1.78-3.73-1.74s-2.68.63-3.63 1.46c-.95-.83-2.27-1.42-3.63-1.46s-2.7.45-3.73 1.74c-1.14 1.44-.96 3.84.34 6.25 1.28 2.42 3.69 4.81 7.02 6.21z" fill="#626262"/></svg>'
		this.cart = '<svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"width="446.843px" height="446.843px" viewBox="0 0 446.843 446.843" style="enable-background:new 0 0 446.843 446.843;"xml:space="preserve"> <g> <path d="M444.09,93.103c-2.698-3.699-7.006-5.888-11.584-5.888H109.92c-0.625,0-1.249,0.038-1.85,0.119l-13.276-38.27 c-1.376-3.958-4.406-7.113-8.3-8.646L19.586,14.134c-7.374-2.887-15.695,0.735-18.591,8.1c-2.891,7.369,0.73,15.695,8.1,18.591 l60.768,23.872l74.381,214.399c-3.283,1.144-6.065,3.663-7.332,7.187l-21.506,59.739c-1.318,3.663-0.775,7.733,1.468,10.916 c2.24,3.183,5.883,5.078,9.773,5.078h11.044c-6.844,7.616-11.044,17.646-11.044,28.675c0,23.718,19.298,43.012,43.012,43.012 s43.012-19.294,43.012-43.012c0-11.029-4.2-21.059-11.044-28.675h93.776c-6.847,7.616-11.048,17.646-11.048,28.675 c0,23.718,19.294,43.012,43.013,43.012c23.718,0,43.012-19.294,43.012-43.012c0-11.029-4.2-21.059-11.043-28.675h13.433 c6.599,0,11.947-5.349,11.947-11.948c0-6.599-5.349-11.947-11.947-11.947H143.647l13.319-36.996 c1.72,0.724,3.578,1.152,5.523,1.152h210.278c6.234,0,11.751-4.027,13.65-9.959l59.739-186.387 C447.557,101.567,446.788,96.802,444.09,93.103z M169.659,409.807c-10.543,0-19.116-8.573-19.116-19.116 s8.573-19.117,19.116-19.117s19.116,8.574,19.116,19.117S180.202,409.807,169.659,409.807z M327.367,409.807 c-10.543,0-19.117-8.573-19.117-19.116s8.574-19.117,19.117-19.117c10.542,0,19.116,8.574,19.116,19.117 S337.909,409.807,327.367,409.807z M402.52,148.149h-73.161V115.89h83.499L402.52,148.149z M381.453,213.861h-52.094v-37.038 h63.967L381.453,213.861z M234.571,213.861v-37.038h66.113v37.038H234.571z M300.684,242.538v31.064h-66.113v-31.064H300.684z M139.115,176.823h66.784v37.038h-53.933L139.115,176.823z M234.571,148.149V115.89h66.113v32.259H234.571z M205.898,115.89v32.259 h-76.734l-11.191-32.259H205.898z M161.916,242.538h43.982v31.064h-33.206L161.916,242.538z M329.359,273.603v-31.064h42.909 l-9.955,31.064H329.359z"/> </g> </svg>'
		this.bell = '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="15" height="16" preserveAspectRatio="xMidYMid meet" viewBox="0 0 15 16" style="-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);"><path fill-rule="evenodd" d="M14 12v1H0v-1l.73-.58c.77-.77.81-2.55 1.19-4.42C2.69 3.23 6 2 6 2c0-.55.45-1 1-1s1 .45 1 1c0 0 3.39 1.23 4.16 5 .38 1.88.42 3.66 1.19 4.42l.66.58H14zm-7 4c1.11 0 2-.89 2-2H5c0 1.11.89 2 2 2z" fill="#626262"/><rect x="0" y="0" width="15" height="16" fill="rgba(0, 0, 0, 0)" /></svg>'
		this.account = '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="1em" height="1em" style="-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path d="M12 4a4 4 0 1 1 0 8 4 4 0 0 1 0-8zm0 10c4.418 0 8 1.79 8 4v2H4v-2c0-2.21 3.582-4 8-4z" fill="#626262"/></svg>'
		this.info = '<svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"viewBox="0 0 23.625 23.625" style="enable-background:new 0 0 23.625 23.625;" xml:space="preserve"> <g> <path style="fill:#030104;" d="M11.812,0C5.289,0,0,5.289,0,11.812s5.289,11.813,11.812,11.813s11.813-5.29,11.813-11.813 S18.335,0,11.812,0z M14.271,18.307c-0.608,0.24-1.092,0.422-1.455,0.548c-0.362,0.126-0.783,0.189-1.262,0.189 c-0.736,0-1.309-0.18-1.717-0.539s-0.611-0.814-0.611-1.367c0-0.215,0.015-0.435,0.045-0.659c0.031-0.224,0.08-0.476,0.147-0.759 l0.761-2.688c0.067-0.258,0.125-0.503,0.171-0.731c0.046-0.23,0.068-0.441,0.068-0.633c0-0.342-0.071-0.582-0.212-0.717 c-0.143-0.135-0.412-0.201-0.813-0.201c-0.196,0-0.398,0.029-0.605,0.09c-0.205,0.063-0.383,0.12-0.529,0.176l0.201-0.828 c0.498-0.203,0.975-0.377,1.43-0.521c0.455-0.146,0.885-0.218,1.29-0.218c0.731,0,1.295,0.178,1.692,0.53 c0.395,0.353,0.594,0.812,0.594,1.376c0,0.117-0.014,0.323-0.041,0.617c-0.027,0.295-0.078,0.564-0.152,0.811l-0.757,2.68 c-0.062,0.215-0.117,0.461-0.167,0.736c-0.049,0.275-0.073,0.485-0.073,0.626c0,0.356,0.079,0.599,0.239,0.728 c0.158,0.129,0.435,0.194,0.827,0.194c0.185,0,0.392-0.033,0.626-0.097c0.232-0.064,0.4-0.121,0.506-0.17L14.271,18.307z M14.137,7.429c-0.353,0.328-0.778,0.492-1.275,0.492c-0.496,0-0.924-0.164-1.28-0.492c-0.354-0.328-0.533-0.727-0.533-1.193 c0-0.465,0.18-0.865,0.533-1.196c0.356-0.332,0.784-0.497,1.28-0.497c0.497,0,0.923,0.165,1.275,0.497 c0.353,0.331,0.53,0.731,0.53,1.196C14.667,6.703,14.49,7.101,14.137,7.429z"/> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> </svg>'
		// this.info = '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="1em" height="1em" style="-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path d="M13.839 17.525c-.006.002-.559.186-1.039.186-.265 0-.372-.055-.406-.079-.168-.117-.48-.336.054-1.4l1-1.994c.593-1.184.681-2.329.245-3.225-.356-.733-1.039-1.236-1.92-1.416a4.776 4.776 0 0 0-.958-.097c-1.849 0-3.094 1.08-3.146 1.126a.5.5 0 0 0 .493.848c.005-.002.559-.187 1.039-.187.263 0 .369.055.402.078.169.118.482.34-.051 1.402l-1 1.995c-.594 1.185-.681 2.33-.245 3.225.356.733 1.038 1.236 1.921 1.416.314.063.636.097.954.097 1.85 0 3.096-1.08 3.148-1.126a.5.5 0 0 0-.491-.849z" fill="#626262"/><circle cx="13" cy="6.001" r="2.5" fill="#626262"/></svg>'
		this.home = '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24" height="24" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24" style="-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);"><path d="M17.896 17.392A1.993 1.993 0 0 0 16 15.999h-1v-3a1 1 0 0 0-1-1H8v-2h2a1 1 0 0 0 1-1v-2h2a2 2 0 0 0 2-2v-.413a7.998 7.998 0 0 1 5 7.413c0 2.08-.801 3.97-2.104 5.393zM11 19.929c-3.945-.493-7-3.852-7-7.93 0-.617.076-1.215.208-1.792L9 14.999v1a2 2 0 0 0 2 2m1-16c-5.523 0-10 4.477-10 10 0 5.522 4.477 10 10 10s10-4.478 10-10c0-5.523-4.477-10-10-10z" fill="#626262"/><rect x="0" y="0" width="24" height="24" fill="rgba(0, 0, 0, 0)" /></svg>'
		this.store = ' <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"width="512px" height="512px" viewBox="0 0 512 512" style="enable-background:new 0 0 512 512;" xml:space="preserve"> <g> <path d="M0,208c0,29.781,20.438,54.594,48,61.75V480H16c-8.813,0-16,7.156-16,16s7.188,16,16,16h480c8.875,0,16-7.156,16-16 s-7.125-16-16-16h-32V269.75c27.562-7.156,48-31.969,48-61.75v-16H0V208z M320,272c35.375,0,64-28.656,64-64 c0,29.781,20.438,54.594,48,61.75V480H192V272c35.375,0,64-28.656,64-64C256,243.344,284.688,272,320,272z M176,269.75V480H80 V269.75c27.563-7.156,48-31.969,48-61.75C128,237.781,148.438,262.594,176,269.75z M448,48H64L0,176h512L448,48z M135.188,83.563 l-32,64c-1.438,2.813-4.25,4.438-7.188,4.438c-1.188,0-2.406-0.25-3.563-0.844c-3.938-1.969-5.563-6.781-3.563-10.719l32-64 c2-3.938,6.781-5.531,10.719-3.594C135.563,74.813,137.125,79.625,135.188,83.563z M199.188,83.563l-32,64 c-1.438,2.813-4.25,4.438-7.188,4.438c-1.188,0-2.406-0.25-3.563-0.844c-3.938-1.969-5.563-6.781-3.563-10.719l32-64 c2-3.938,6.813-5.531,10.719-3.594C199.563,74.813,201.125,79.625,199.188,83.563z M264,144c0,4.438-3.562,8-8,8 c-4.406,0-8-3.563-8-8V80c0-4.438,3.594-8,8-8c4.438,0,8,3.563,8,8V144z M355.875,151c-1.25,0.688-2.562,1-3.875,1 c-2.812,0-5.562-1.5-7-4.156l-35-64c-2.125-3.875-0.688-8.75,3.188-10.844c3.813-2.125,8.75-0.75,10.875,3.156l35,64 C361.125,144.031,359.75,148.906,355.875,151z M419.562,151.156C418.438,151.75,417.25,152,416,152 c-2.938,0-5.75-1.625-7.125-4.438l-32-64c-2-3.938-0.375-8.75,3.562-10.719c3.875-1.969,8.75-0.375,10.75,3.594l32,64 C425.125,144.375,423.562,149.188,419.562,151.156z M136,386.438v-36.875c-4.688-2.812-8-7.688-8-13.562c0-8.844,7.188-16,16-16 c8.875,0,16,7.156,16,16c0,5.875-3.281,10.75-8,13.562v36.875c4.719,2.813,8,7.688,8,13.563c0,8.844-7.125,16-16,16 c-8.813,0-16-7.156-16-16C128,394.125,131.313,389.25,136,386.438z M64,16c0-8.844,7.188-16,16-16h352c8.875,0,16,7.156,16,16 s-7.125,16-16,16H80C71.188,32,64,24.844,64,16z M280.438,357.656l-11.312-11.313l45.25-45.25l11.312,11.313L280.438,357.656z M280.438,402.906l-11.312-11.313l90.5-90.5l11.312,11.313L280.438,402.906z M359.625,346.344l11.312,11.313l-45.25,45.25 l-11.312-11.313L359.625,346.344z"/> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> <g> </g> </svg>'
		this.earth = '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24" height="24" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24" style="-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);"><path d="M17.896 17.392A1.993 1.993 0 0 0 16 15.999h-1v-3a1 1 0 0 0-1-1H8v-2h2a1 1 0 0 0 1-1v-2h2a2 2 0 0 0 2-2v-.413a7.998 7.998 0 0 1 5 7.413c0 2.08-.801 3.97-2.104 5.393zM11 19.929c-3.945-.493-7-3.852-7-7.93 0-.617.076-1.215.208-1.792L9 14.999v1a2 2 0 0 0 2 2m1-16c-5.523 0-10 4.477-10 10 0 5.522 4.477 10 10 10s10-4.478 10-10c0-5.523-4.477-10-10-10z" fill="#626262"/><rect x="0" y="0" width="24" height="24" fill="rgba(0, 0, 0, 0)" /></svg>'
		this.exit = '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="1em" height="1em" style="-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path d="M4 12a1 1 0 0 0 1 1h7.59l-2.3 2.29a1 1 0 0 0 0 1.42 1 1 0 0 0 1.42 0l4-4a1 1 0 0 0 .21-.33 1 1 0 0 0 0-.76 1 1 0 0 0-.21-.33l-4-4a1 1 0 1 0-1.42 1.42l2.3 2.29H5a1 1 0 0 0-1 1zM17 2H7a3 3 0 0 0-3 3v3a1 1 0 0 0 2 0V5a1 1 0 0 1 1-1h10a1 1 0 0 1 1 1v14a1 1 0 0 1-1 1H7a1 1 0 0 1-1-1v-3a1 1 0 0 0-2 0v3a3 3 0 0 0 3 3h10a3 3 0 0 0 3-3V5a3 3 0 0 0-3-3z" fill="#626262"/></svg>'
		this.quote = '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="1em" height="1em" style="-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 16 16"><path d="M12.5 10A3.5 3.5 0 1 1 16 6.5l.016.5a7 7 0 0 1-7 7v-2a4.97 4.97 0 0 0 3.536-1.464 5.01 5.01 0 0 0 .497-.578 3.547 3.547 0 0 1-.549.043zm-9 0A3.5 3.5 0 1 1 7 6.5l.016.5a7 7 0 0 1-7 7v-2a4.97 4.97 0 0 0 3.536-1.464 5.01 5.01 0 0 0 .497-.578 3.547 3.547 0 0 1-.549.043z" fill="#626262"/></svg>'
		this.copy = '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="24" height="24" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24" style="-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);"><path d="M22 15.998a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2v-12a2 2 0 0 1 2-2L20 2a2 2 0 0 1 2 2v11.998zM16 20v2H4a2 2 0 0 1-2-2V7h2v13.001L16 20z" fill="#626262"/><rect x="0" y="0" width="24" height="24" fill="rgba(0, 0, 0, 0)" /></svg>'
		this.option = '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="1em" height="1em" style="-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 1024 1024"><path d="M512.5 390.6c-29.9 0-57.9 11.6-79.1 32.8-21.1 21.2-32.8 49.2-32.8 79.1 0 29.9 11.7 57.9 32.8 79.1 21.2 21.1 49.2 32.8 79.1 32.8 29.9 0 57.9-11.7 79.1-32.8 21.1-21.2 32.8-49.2 32.8-79.1 0-29.9-11.7-57.9-32.8-79.1a110.96 110.96 0 0 0-79.1-32.8zm412.3 235.5l-65.4-55.9c3.1-19 4.7-38.4 4.7-57.7s-1.6-38.8-4.7-57.7l65.4-55.9a32.03 32.03 0 0 0 9.3-35.2l-.9-2.6a442.5 442.5 0 0 0-79.6-137.7l-1.8-2.1a32.12 32.12 0 0 0-35.1-9.5l-81.2 28.9c-30-24.6-63.4-44-99.6-57.5l-15.7-84.9a32.05 32.05 0 0 0-25.8-25.7l-2.7-.5c-52-9.4-106.8-9.4-158.8 0l-2.7.5a32.05 32.05 0 0 0-25.8 25.7l-15.8 85.3a353.44 353.44 0 0 0-98.9 57.3l-81.8-29.1a32 32 0 0 0-35.1 9.5l-1.8 2.1a445.93 445.93 0 0 0-79.6 137.7l-.9 2.6c-4.5 12.5-.8 26.5 9.3 35.2l66.2 56.5c-3.1 18.8-4.6 38-4.6 57 0 19.2 1.5 38.4 4.6 57l-66 56.5a32.03 32.03 0 0 0-9.3 35.2l.9 2.6c18.1 50.3 44.8 96.8 79.6 137.7l1.8 2.1a32.12 32.12 0 0 0 35.1 9.5l81.8-29.1c29.8 24.5 63 43.9 98.9 57.3l15.8 85.3a32.05 32.05 0 0 0 25.8 25.7l2.7.5a448.27 448.27 0 0 0 158.8 0l2.7-.5a32.05 32.05 0 0 0 25.8-25.7l15.7-84.9c36.2-13.6 69.6-32.9 99.6-57.5l81.2 28.9a32 32 0 0 0 35.1-9.5l1.8-2.1c34.8-41.1 61.5-87.4 79.6-137.7l.9-2.6c4.3-12.4.6-26.3-9.5-35zm-412.3 52.2c-97.1 0-175.8-78.7-175.8-175.8s78.7-175.8 175.8-175.8 175.8 78.7 175.8 175.8-78.7 175.8-175.8 175.8z" fill="#626262"/></svg>'
		this.theme = '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="1em" height="1em" style="-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path d="M12 3a9 9 0 0 0 0 18c.83 0 1.5-.67 1.5-1.5 0-.39-.15-.74-.39-1.01-.23-.26-.38-.61-.38-.99 0-.83.67-1.5 1.5-1.5H16c2.76 0 5-2.24 5-5 0-4.42-4.03-8-9-8zm-5.5 9c-.83 0-1.5-.67-1.5-1.5S5.67 9 6.5 9 8 9.67 8 10.5 7.33 12 6.5 12zm3-4C8.67 8 8 7.33 8 6.5S8.67 5 9.5 5s1.5.67 1.5 1.5S10.33 8 9.5 8zm5 0c-.83 0-1.5-.67-1.5-1.5S13.67 5 14.5 5s1.5.67 1.5 1.5S15.33 8 14.5 8zm3 4c-.83 0-1.5-.67-1.5-1.5S16.67 9 17.5 9s1.5.67 1.5 1.5-.67 1.5-1.5 1.5z" fill="#626262"/></svg>'
		this.check = '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="20" height="20" preserveAspectRatio="xMidYMid meet" viewBox="0 0 20 20" style="-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);"><path d="M8.294 16.998c-.435 0-.847-.203-1.111-.553L3.61 11.724a1.392 1.392 0 0 1 .27-1.951 1.392 1.392 0 0 1 1.953.27l2.351 3.104 5.911-9.492a1.396 1.396 0 0 1 1.921-.445c.653.406.854 1.266.446 1.92L9.478 16.34a1.39 1.39 0 0 1-1.12.656c-.022.002-.042.002-.064.002z" fill="#626262"/><rect x="0" y="0" width="20" height="20" fill="rgba(0, 0, 0, 0)" /></svg>'
		this.brain = '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="1em" height="1em" style="-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path d="M21.33 12.91a4.54 4.54 0 0 1-1.89 3.95l.77 1.49c.234.45.256.982.06 1.45a1.73 1.73 0 0 1-1.06 1l-.79.25a1.699 1.699 0 0 1-1.86-.53L14.44 18A5.3 5.3 0 0 1 12 16.9a5.18 5.18 0 0 1-1.48.23A4.34 4.34 0 0 1 8 16.34a5.65 5.65 0 0 1-1.62.22 5.82 5.82 0 0 1-2.3-.45 4.11 4.11 0 0 1-2.43-3.61A3.86 3.86 0 0 1 2 10.39a3.48 3.48 0 0 1-.07-2.33 4.45 4.45 0 0 1 1.94-2.24 4 4 0 0 1 4-2.7 4.59 4.59 0 0 1 5.83-.37 5.209 5.209 0 0 1 1.3-.17 4.3 4.3 0 0 1 3.49 1.64 4.8 4.8 0 0 1 3.59 4.47 5.24 5.24 0 0 1-.86 3.13c.074.358.111.724.11 1.09zm-5-1.41c.572.07 1.02.518 1.02 1.07a1 1 0 0 1-1 1h-.63a5.12 5.12 0 0 1-1.62 2.29c.251.09.508.16.77.21 5.13-.07 4.53-3.205 4.528-3.252a2.59 2.59 0 0 0-2.688-2.488 1 1 0 1 1 0-2 5.25 5.25 0 0 1 3.33 1.3 5.43 5.43 0 0 0 .08-.89c-.058-1.252-.62-2.32-2.87-2.53-1.25-2.96-4.4-1.32-4.4-.4-.026.227.21.724.25.75a1 1 0 1 1 0 2A2.33 2.33 0 0 1 11.67 8a3.62 3.62 0 0 1-1.6.56 1.004 1.004 0 1 1-.19-2c.16-.02.94-.14.94-.77A2.7 2.7 0 0 1 11.51 4c-.93-.246-1.916.085-2.92 1.29C6.75 5 6 5.25 5.45 7.2 4.506 7.666 4 8 3.78 9A5.9 5.9 0 0 1 7 9.25a1.003 1.003 0 0 1-.7 1.88 3.07 3.07 0 0 0-2.3-.06c-.32.27-.32.83-.32 1.27a2.15 2.15 0 0 0 1 1.83 3.66 3.66 0 0 0 1.71.4 5.37 5.37 0 0 1-.39-.81 1.037 1.037 0 0 1 1.96-.68 3.08 3.08 0 0 0 2.62 2.05 3.76 3.76 0 0 0 3.19-2.11c.22-1.4 1.34-1.52 2.56-1.52zm2 7.47l-.62-1.3-.7.16 1 1.25.32-.11zm-4.65-8.61a1 1 0 0 0-.91-1.03c-.707-.04-1.4.2-1.93.67a2.9 2.9 0 0 0-.82 2.19 1 1 0 1 0 2 0c-.025-.27.05-.54.21-.76a.7.7 0 0 1 .43-.15c.545.035 1.017-.375 1.02-.92z" fill="#626262"/></svg>'
		this.list = '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true" focusable="false" width="1em" height="1em" style="-ms-transform: rotate(360deg); -webkit-transform: rotate(360deg); transform: rotate(360deg);" preserveAspectRatio="xMidYMid meet" viewBox="0 0 24 24"><path d="M10 4h10a1 1 0 0 1 0 2H10a1 1 0 1 1 0-2zm0 7h10a1 1 0 0 1 0 2H10a1 1 0 0 1 0-2zm0 7h10a1 1 0 0 1 0 2H10a1 1 0 0 1 0-2zM5 7a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm0 7a2 2 0 1 1 0-4 2 2 0 0 1 0 4zm0 7a2 2 0 1 1 0-4 2 2 0 0 1 0 4z" fill="#626262" fill-rule="evenodd"/></svg>' 
	}
}