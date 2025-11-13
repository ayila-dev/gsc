const API_BASE = "/gsc/backend/Models";
const API_LOGIN = "/gsc/backend/Views/pages";

window.GSC = {
	API: {
		index: {
			login: async (formData) => {
				const res = await fetch(`${API_LOGIN}/login.php?action=login`, {
					method: "POST",
					body: formData,
				});
				return await res.json();
			},
		},
		firstConnection: {
			connect: async (formData) => {
				const res = await fetch(
					`${API_LOGIN}/login.php?action=connect`,
					{
						method: "POST",
						body: formData,
					}
				);
				return await res.json();
			},
		},
		personals: {
			add: async (formData) => {
				const res = await fetch(`${API_BASE}/Personal.php?action=add`, {
					method: "POST",
					body: formData,
				});
				return await res.json();
			},
			list: async () => {
				const res = await fetch(`${API_BASE}/Personal.php?action=list`);
				return await res.json();
			},
			update: async (id, formData) => {
				formData.append("user_id", id);
				const res = await fetch(
					`${API_BASE}/Personal.php?action=update`,
					{
						method: "POST",
						body: formData,
					}
				);
				return await res.json();
			},
			delete: async (id) => {
				const res = await fetch(
					`${API_BASE}/Personal.php?action=delete&id=${id}`,
					{
						method: "GET",
					}
				);
				return await res.json();
			},
		},
		teachers: {
			add: async (formData) => {
				const res = await fetch(`${API_BASE}/Teacher.php?action=add`, {
					method: "POST",
					body: formData,
				});
				return await res.json();
			},
			list: async () => {
				const res = await fetch(`${API_BASE}/Teacher.php?action=list`);
				return await res.json();
			},
			update: async (id, formData) => {
				formData.append("user_id", id);
				const res = await fetch(
					`${API_BASE}/Teacher.php?action=update`,
					{
						method: "POST",
						body: formData,
					}
				);
				return await res.json();
			},
			delete: async (id) => {
				const res = await fetch(
					`${API_BASE}/Teacher.php?action=delete&id=${id}`,
					{
						method: "GET",
					}
				);
				return await res.json();
			},
			listPlace: async () => {
				const res = await fetch(`${API_BASE}/Teacher.php?action=place`);
				return await res.json();
			},
		},
		parents: {
			add: async (formData) => {
				const res = await fetch(`${API_BASE}/Parent.php?action=add`, {
					method: "POST",
					body: formData,
				});
				return await res.json();
			},
			list: async () => {
				const res = await fetch(`${API_BASE}/Parent.php?action=list`);
				return await res.json();
			},
			get: async (id) => {
				const res = await fetch(
					`${API_BASE}/Parent.php?action=get&id=${id}`
				);
				return await res.json();
			},
			update: async (id, formData) => {
				formData.append("user_id", id);
				const res = await fetch(
					`${API_BASE}/Parent.php?action=update`,
					{
						method: "POST",
						body: formData,
					}
				);
				return await res.json();
			},
			delete: async (id) => {
				const res = await fetch(
					`${API_BASE}/Parent.php?action=delete&id=${id}`,
					{
						method: "GET",
					}
				);
				return await res.json();
			},
		},
		students: {
			add: async (formData) => {
				console.log(...formData);
				const res = await fetch(`${API_BASE}/Student.php?action=add`, {
					method: "POST",
					body: formData,
				});
				return await res.json();
			},
			list: async () => {
				const res = await fetch(`${API_BASE}/Student.php?action=list`);
				return await res.json();
			},
			get: async (id) => {
				const res = await fetch(
					`${API_BASE}/Student.php?action=get&id=${id}`
				);
				return await res.json();
			},
			update: async (id, formData) => {
				formData.append("student_id", id);
				const res = await fetch(
					`${API_BASE}/Student.php?action=update`,
					{
						method: "POST",
						body: formData,
					}
				);
				return await res.json();
			},
			reinscription: async (formData) => {
				const res = await fetch(
					`${API_BASE}/Student.php?action=reinscription`,
					{
						method: "POST",
						body: formData,
					}
				);
				return await res.json();
			},
			delete: async (id) => {
				const res = await fetch(
					`${API_BASE}/Student.php?action=delete&id=${id}`,
					{
						method: "GET",
					}
				);
				return await res.json();
			},
		},
		schedules: {
			add: async (formData) => {
				const res = await fetch(`${API_BASE}/Schedule.php?action=add`, {
					method: "POST",
					body: formData,
				});
				return await res.json();
			},
			list: async () => {
				const res = await fetch(`${API_BASE}/Schedule.php?action=list`);
				return await res.json();
			},
			get: async (id) => {
				const res = await fetch(
					`${API_BASE}/Schedule.php?action=get&id=${id}`
				);
				return await res.json();
			},
			update: async (id, formData) => {
				formData.append("schedule_id", id);
				const res = await fetch(
					`${API_BASE}/Schedule.php?action=update`,
					{
						method: "POST",
						body: formData,
					}
				);
				return await res.json();
			},
			delete: async (id) => {
				const res = await fetch(
					`${API_BASE}/Schedule.php?action=delete&id=${id}`,
					{
						method: "GET",
					}
				);
				return await res.json();
			},
			generateTimetablePDF: async (formData) => {
				const res = await fetch(
					`${API_BASE}/Schedule.php?action=generate-timetable-pdf`,
					{
						method: "POST",
						body: formData,
					}
				);
				console.log([...formData]);
				return await res.json();
			},
		},
		scolarities: {
			add: async (formData) => {
				const res = await fetch(
					`${API_BASE}/Scolarity.php?action=add`,
					{
						method: "POST",
						body: formData,
					}
				);
				return await res.json();
			},
			list: async () => {
				const res = await fetch(
					`${API_BASE}/Scolarity.php?action=list`
				);
				return await res.json();
			},
			pay: async (id) => {
				const res = await fetch(
					`${API_BASE}/Scolarity.php?action=pay&id=${id}`
				);
				return await res.json();
			},
		},
		grades: {
			add: async (formData) => {
				const res = await fetch(
					`${API_BASE}/Setting.php?action=add-year`,
					{ method: "POST", body: formData }
				);
				return await res.json();
			},
			list: async () => {
				const res = await fetch(
					`${API_BASE}/Setting.php?action=list-years`
				);
				return await res.json();
			},
			get: async (id) => {
				const res = await fetch(
					`${API_BASE}/Setting.php?action=get-year&id=${id}`
				);
				return await res.json();
			},
			update: async (id, formData) => {
				formData.append("year_id", id);
				const res = await fetch(
					`${API_BASE}/Setting.php?action=update-year`,
					{ method: "POST", body: formData }
				);
				return await res.json();
			},
			delete: async (id) => {
				const res = await fetch(
					`${API_BASE}/Setting.php?action=delete-year&id=${id}`
				);
				return await res.json();
			},
		},
		settings: {
			years: {
				add: async (formData) => {
					const res = await fetch(
						`${API_BASE}/Setting.php?action=add-year`,
						{ method: "POST", body: formData }
					);
					return await res.json();
				},
				list: async () => {
					const res = await fetch(
						`${API_BASE}/Setting.php?action=list-years`
					);
					return await res.json();
				},
				get: async (id) => {
					const res = await fetch(
						`${API_BASE}/Setting.php?action=get-year&id=${id}`
					);
					return await res.json();
				},
				update: async (id, formData) => {
					formData.append("year_id", id);
					const res = await fetch(
						`${API_BASE}/Setting.php?action=update-year`,
						{ method: "POST", body: formData }
					);
					return await res.json();
				},
				delete: async (id) => {
					const res = await fetch(
						`${API_BASE}/Setting.php?action=delete-year&id=${id}`
					);
					return await res.json();
				},
			},
			places: {
				add: async (formData) => {
					const res = await fetch(
						`${API_BASE}/Setting.php?action=add-place`,
						{ method: "POST", body: formData }
					);
					return await res.json();
				},
				list: async () => {
					const res = await fetch(
						`${API_BASE}/Setting.php?action=list-places`
					);
					return await res.json();
				},
				get: async (id) => {
					const res = await fetch(
						`${API_BASE}/Setting.php?action=get-place&id=${id}`
					);
					return await res.json();
				},
				update: async (id, formData) => {
					formData.append("place_id", id);
					const res = await fetch(
						`${API_BASE}/Setting.php?action=update-place`,
						{ method: "POST", body: formData }
					);
					return await res.json();
				},
				delete: async (id) => {
					const res = await fetch(
						`${API_BASE}/Setting.php?action=delete-place&id=${id}`
					);
					return await res.json();
				},
			},
			cycles: {
				add: async (formData) => {
					const res = await fetch(
						`${API_BASE}/Setting.php?action=add-cycle`,
						{ method: "POST", body: formData }
					);
					return await res.json();
				},
				list: async () => {
					const res = await fetch(
						`${API_BASE}/Setting.php?action=list-cycles`
					);
					return await res.json();
				},
				get: async (id) => {
					const res = await fetch(
						`${API_BASE}/Setting.php?action=get-cycle&id=${id}`
					);
					return await res.json();
				},
				update: async (id, formData) => {
					formData.append("cycle_id", id);
					const res = await fetch(
						`${API_BASE}/Setting.php?action=update-cycle`,
						{ method: "POST", body: formData }
					);
					return await res.json();
				},
				delete: async (id) => {
					const res = await fetch(
						`${API_BASE}/Setting.php?action=delete-cycle&id=${id}`
					);
					return await res.json();
				},
			},
			levels: {
				add: async (formData) => {
					const res = await fetch(
						`${API_BASE}/Setting.php?action=add-level`,
						{ method: "POST", body: formData }
					);
					return await res.json();
				},
				list: async () => {
					const res = await fetch(
						`${API_BASE}/Setting.php?action=list-levels`
					);
					return await res.json();
				},
				get: async (id) => {
					const res = await fetch(
						`${API_BASE}/Setting.php?action=get-level&id=${id}`
					);
					return await res.json();
				},
				update: async (id, formData) => {
					formData.append("level_id", id);
					const res = await fetch(
						`${API_BASE}/Setting.php?action=update-level`,
						{ method: "POST", body: formData }
					);
					return await res.json();
				},
				delete: async (id) => {
					const res = await fetch(
						`${API_BASE}/Setting.php?action=delete-level&id=${id}`
					);
					return await res.json();
				},
			},
			rooms: {
				add: async (formData) => {
					const res = await fetch(
						`${API_BASE}/Setting.php?action=add-room`,
						{ method: "POST", body: formData }
					);
					return await res.json();
				},
				list: async () => {
					const res = await fetch(
						`${API_BASE}/Setting.php?action=list-rooms`
					);
					return await res.json();
				},
				get: async (id) => {
					const res = await fetch(
						`${API_BASE}/Setting.php?action=get-room&id=${id}`
					);
					return await res.json();
				},
				update: async (id, formData) => {
					formData.append("room_id", id);
					const res = await fetch(
						`${API_BASE}/Setting.php?action=update-room`,
						{ method: "POST", body: formData }
					);
					return await res.json();
				},
				delete: async (id) => {
					const res = await fetch(
						`${API_BASE}/Setting.php?action=delete-room&id=${id}`
					);
					return await res.json();
				},
			},
			series: {
				add: async (formData) => {
					const res = await fetch(
						`${API_BASE}/Setting.php?action=add-serie`,
						{ method: "POST", body: formData }
					);
					return await res.json();
				},
				list: async () => {
					const res = await fetch(
						`${API_BASE}/Setting.php?action=list-series`
					);
					return await res.json();
				},
				get: async (id) => {
					const res = await fetch(
						`${API_BASE}/Setting.php?action=get-serie&id=${id}`
					);
					return await res.json();
				},
				update: async (id, formData) => {
					formData.append("serie_id", id);
					const res = await fetch(
						`${API_BASE}/Setting.php?action=update-serie`,
						{ method: "POST", body: formData }
					);
					return await res.json();
				},
				delete: async (id) => {
					const res = await fetch(
						`${API_BASE}/Setting.php?action=delete-serie&id=${id}`
					);
					return await res.json();
				},
			},
			schoolings: {
				add: async (formData) => {
					const res = await fetch(
						`${API_BASE}/Setting.php?action=add-schooling`,
						{ method: "POST", body: formData }
					);
					return await res.json();
				},
				list: async () => {
					const res = await fetch(
						`${API_BASE}/Setting.php?action=list-schoolings`
					);
					return await res.json();
				},
				get: async (id) => {
					const res = await fetch(
						`${API_BASE}/Setting.php?action=get-schooling&id=${id}`
					);
					return await res.json();
				},
				update: async (id, formData) => {
					formData.append("schooling_id", id);
					const res = await fetch(
						`${API_BASE}/Setting.php?action=update-schooling`,
						{ method: "POST", body: formData }
					);
					return await res.json();
				},
				delete: async (id) => {
					const res = await fetch(
						`${API_BASE}/Setting.php?action=delete-schooling&id=${id}`
					);
					return await res.json();
				},
			},
			courses: {
				add: async (formData) => {
					const res = await fetch(
						`${API_BASE}/Setting.php?action=add-course`,
						{ method: "POST", body: formData }
					);
					return await res.json();
				},
				list: async () => {
					const res = await fetch(
						`${API_BASE}/Setting.php?action=list-courses`
					);
					return await res.json();
				},
				get: async (id) => {
					const res = await fetch(
						`${API_BASE}/Setting.php?action=get-course&id=${id}`
					);
					return await res.json();
				},
				update: async (id, formData) => {
					formData.append("course_id", id);
					const res = await fetch(
						`${API_BASE}/Setting.php?action=update-course`,
						{ method: "POST", body: formData }
					);
					return await res.json();
				},
				delete: async (id) => {
					const res = await fetch(
						`${API_BASE}/Setting.php?action=delete-course&id=${id}`
					);
					return await res.json();
				},
			},
			roles: {
				add: async (formData) => {
					const res = await fetch(
						`${API_BASE}/Setting.php?action=add-role`,
						{ method: "POST", body: formData }
					);
					return await res.json();
				},
				list: async () => {
					const res = await fetch(
						`${API_BASE}/Setting.php?action=list-roles`
					);
					return await res.json();
				},
				get: async (id) => {
					const res = await fetch(
						`${API_BASE}/Setting.php?action=get-role&id=${id}`
					);
					return await res.json();
				},
				update: async (id, formData) => {
					formData.append("role_id", id);
					const res = await fetch(
						`${API_BASE}/Setting.php?action=update-role`,
						{ method: "POST", body: formData }
					);
					return await res.json();
				},
				delete: async (id) => {
					const res = await fetch(
						`${API_BASE}/Setting.php?action=delete-role&id=${id}`
					);
					return await res.json();
				},
			},
			access: {
				add: async (formData) => {
					const res = await fetch(
						`${API_BASE}/Setting.php?action=add-access`,
						{ method: "POST", body: formData }
					);
					return await res.json();
				},
				list: async () => {
					const res = await fetch(
						`${API_BASE}/Setting.php?action=list-access`
					);
					return await res.json();
				},
				get: async (id) => {
					const res = await fetch(
						`${API_BASE}/Setting.php?action=get-access&id=${id}`
					);
					return await res.json();
				},
				update: async (id, formData) => {
					formData.append("access_id", id);
					const res = await fetch(
						`${API_BASE}/Setting.php?action=update-access`,
						{ method: "POST", body: formData }
					);
					return await res.json();
				},
				delete: async (id) => {
					const res = await fetch(
						`${API_BASE}/Setting.php?action=delete-access&id=${id}`
					);
					return await res.json();
				},
			},
			fees: {
				add: async (formData) => {
					const res = await fetch(
						`${API_BASE}/Setting.php?action=add-fee`,
						{ method: "POST", body: formData }
					);
					return await res.json();
				},
				list: async () => {
					const res = await fetch(
						`${API_BASE}/Setting.php?action=list-fees`
					);
					return await res.json();
				},
				get: async (id) => {
					const res = await fetch(
						`${API_BASE}/Setting.php?action=get-fee&id=${id}`
					);
					return await res.json();
				},
				update: async (id, formData) => {
					formData.append("fee_id", id);
					const res = await fetch(
						`${API_BASE}/Setting.php?action=update-fee`,
						{ method: "POST", body: formData }
					);
					return await res.json();
				},
				delete: async (id) => {
					const res = await fetch(
						`${API_BASE}/Setting.php?action=delete-fee&id=${id}`
					);
					return await res.json();
				},
			},
		},
	},
};
