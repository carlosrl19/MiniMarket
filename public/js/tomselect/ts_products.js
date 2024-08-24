new TomSelect("#producto_id", {
    create: false,
    sortField: {
        field: "text",
        direction: "asc",
    },
    plugins: {
		'clear_button':{
			'title':'Quitar selección',
		}
	}
});
