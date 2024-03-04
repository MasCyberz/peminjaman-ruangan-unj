/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./resources/**/*.blade.php",
        "./resources/**/*.js",
        "./resources/**/*.vue",
        "./node_modules/flowbite/**/*.js",
    ],
    theme: {
        extend: {
            fontFamily: {
				unj: ["Praise"],
				poppins: ["Poppins"],
			},

			screens: {
				desktop: "1280px",
			},
			backgroundImage: {
				unjbg: "url('./img/loginbg.png')",
			},
			borderRadius: {
				chonk: "20px",
				"10pixel": "10px",
			},
			colors: {
				ijounj: "#266B45",
				putihkotor: "#D9D9D9",
				buttonunj: "#305067",
				unjboard: "#BCCFDD",
				sidebarunj: "#305067",
				dimas: "#6B7D21",
				putihan: "#FAF9FF",
				biruan: "#B9C2FF",
			},
			opacity: {
				76: "76%",
				67: "67%",
			},
			borderWidth: {
				"80%": "100px",
			},
			dropShadow: {
				"3xl": "0 35px 35px rgba(0, 0, 0, 0.25)",
			},
			gridTemplateColumns: {
				DaRef: "1fr 1fr",

			},
			gridTemplateRows: {
				DaRef: "1fr",
			},
			blur: {
				ssm: '1px',
			},
			boxShadow: {
				'all-side': '0px 0px 30px 2px rgba(0, 0, 0, 0.25)',
			},
        },
    },
    plugins: [
        require('flowbite/plugin')
    ],
};
