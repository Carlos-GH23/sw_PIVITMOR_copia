import { ICONS } from "@/Utils/Icons";
import { IMAGES } from "@/Utils/Image";
import {
    mdiAccountMultipleOutline,
    mdiDomain,
    mdiSchoolOutline,
    mdiTownHall,
    mdiHandshakeOutline,
} from "@mdi/js";

export const benefits = [
    {
        src: ICONS.government.src,
        title: "Gobierno",
        description:
            "Acceso a un ecosistema centralizado para identificar y conectar con ofertas tecnológicas, impulsar proyectos estratégicos y optimizar políticas públicas.",
    },
    {
        src: ICONS.academic.src,
        title: "Academia",
        description:
            "Difusión y vinculación efectiva de proyectos, capacidades de investigación y transferencia tecnológica hacia sectores que requieren innovación.",
    },
    {
        src: ICONS.industry.src,
        title: "Empresas / Industria",
        description:
            "Identificación de soluciones tecnológicas, talento especializado y oportunidades de colaboración para acelerar la competitividad y el crecimiento.",
    },
    {
        src: ICONS.society.src,
        title: "Sociedad",
        description:
            "Acceso a soluciones que mejoran la calidad de vida y fomentan la participación ciudadana en proyectos de innovación y desarrollo.",
    },
    {
        src: ICONS.ecology.src,
        title: "Ecología",
        description:
            "Promoción y adopción de tecnologías sostenibles que protegen el medio ambiente y fomentan un desarrollo económico responsable.",
    },
];

export const testimonials = [
    {
        id: 1,
        title: "Sistema de monitoreo IoT para viveros agrícolas",
        description:
            "Desarrollado por ITMorelos y AgrotechMx, este sistema revoluciona el monitoreo de cultivos mediante sensores inteligentes.",
        requirement: "ITMorelos",
        capability: "AgrotechMx",
        sector: "Ecología",
        user: {
            selfie: IMAGES.user.src,
            name: "Ing. Raúl Martínez",
            company: "AgroSoluciones S.A",
            title: "Gracias a PIVITMor, encontramos una solución tecnológica a un problema crítico de producción.",
            comments:
                "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris ac justo quis velit faucibus sagittis sit amet sit amet augue. Nam nibh augue, hendrerit ac aliquam quis, elementum ac dolor. Nulla mi leo, condimentum et purus sed, pulvinar tempor ante. Mauris sed dui quis risus lobortis condimentum in ac dolor. Praesent felis orci, elementum et fringilla vitae, ultrices in risus. Proin id dignissim sapien. Duis malesuada pulvinar sapien, eget rutrum justo elementum id. Nulla consectetur eros lectus, a tincidunt mauris ornare ac. Nunc vel sem nisi. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris ac justo quis velit faucibus sagittis sit amet sit amet augue. Nam nibh augue, hendrerit ac aliquam quis, elementum ac dolor. Nulla mi leo, condimentum et purus sed, pulvinar tempor ante. Mauris sed dui quis risus lobortis condimentum in ac dolor. Praesent felis orci, elementum et fringilla vitae, ultrices in risus. Proin id dignissim sapien. Duis malesuada pulvinar sapien, eget rutrum justo elementum id. Nulla consectetur eros lectus, a tincidunt mauris ornare ac. Nunc vel sem nisi.",
        },
        highlight: "Impacto: 40% aumento de cultivos",
    },
    {
        id: 2,
        title: "Plataforma de telemedicina para zonas rurales",
        description:
            "Una colaboración entre SaludDigital y TecnoSalud, esta plataforma acerca servicios médicos especializados a comunidades remotas.",
        requirement: "SaludDigital",
        capability: "TecnoSalud",
        sector: "Sociedad",
        user: {
            selfie: IMAGES.user.src,
            name: "Dra. Ana Gómez",
            company: "Clínica Rural Esperanza",
            title: "PIVITMor nos permitió conectar con la tecnología necesaria para mejorar la salud en nuestra comunidad.",
            comments:
                "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris ac justo quis velit faucibus sagittis sit amet sit amet augue. Nam nibh augue, hendrerit ac aliquam quis, elementum ac dolor. Nulla mi leo, condimentum et purus sed, pulvinar tempor ante. Mauris sed dui quis risus lobortis condimentum in ac dolor. Praesent felis orci, elementum et fringilla vitae, ultrices in risus. Proin id dignissim sapien. Duis malesuada pulvinar sapien, eget rutrum justo elementum id. Nulla consectetur eros lectus, a tincidunt mauris ornare ac. Nunc vel sem nisi.",
        },
        highlight: "Impacto: 60% reducción de traslados",
    },
    {
        id: 3,
        title: "Software de gestión de residuos urbanos con IA",
        description:
            "Desarrollado por EcoSmart y UrbanTech, este software optimiza la recolección y clasificación de residuos, mejorando la eficiencia y reduciendo el impacto ambiental.",
        requirement: "EcoSmart",
        capability: "UrbanTech",
        sector: "Ecología",
        user: {
            selfie: IMAGES.user.src,
            name: "Lic. Carlos Pérez",
            company: "Ayuntamiento de Morelos",
            title: "La implementación de esta tecnología a través de PIVITMor ha transformado la gestión de residuos en nuestra ciudad.",
            comments:
                "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris ac justo quis velit faucibus sagittis sit amet sit amet augue. Nam nibh augue, hendrerit ac aliquam quis, elementum ac dolor. Nulla mi leo, condimentum et purus sed, pulvinar tempor ante. Mauris sed dui quis risus lobortis condimentum in ac dolor. Praesent felis orci, elementum et fringilla vitae, ultrices in risus. Proin id dignissim sapien. Duis malesuada pulvinar sapien, eget rutrum justo elementum id. Nulla consectetur eros lectus, a tincidunt mauris ornare ac. Nunc vel sem nisi.",
        },
        highlight: "Impacto: 25% reducción de costos operativos",
    },
    {
        id: 4,
        title: "Aplicación móvil para el fomento del turismo sostenible",
        description:
            "Una iniciativa conjunta de TurismoVerde y AppSolutions, esta app promueve destinos turísticos responsables y apoya a comunidades locales.",
        requirement: "TurismoVerde",
        capability: "AppSolutions",
        sector: "Sociedad",
        user: {
            selfie: IMAGES.user.src,
            name: "Mtra. Laura Fernández",
            company: "Secretaría de Turismo",
            title: "PIVITMor fue clave para encontrar el socio tecnológico ideal y lanzar esta aplicación que beneficia a todos.",
            comments:
                "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris ac justo quis velit faucibus sagittis sit amet sit amet augue. Nam nibh augue, hendrerit ac aliquam quis, elementum ac dolor. Nulla mi leo, condimentum et purus sed, pulvinar tempor ante. Mauris sed dui quis risus lobortis condimentum in ac dolor. Praesent felis orci, elementum et fringilla vitae, ultrices in risus. Proin id dignissim sapien. Duis malesuada pulvinar sapien, eget rutrum justo elementum id. Nulla consectetur eros lectus, a tincidunt mauris ornare ac. Nunc vel sem nisi.",
        },
        highlight: "Impacto: 30% aumento de visitantes",
    },
    {
        id: 5,
        title: "Sistema de alerta temprana para desastres naturales",
        description:
            "Desarrollado por GeoRisk y DataGuard, este sistema utiliza IA para predecir y alertar sobre fenómenos naturales, salvaguardando vidas y bienes.",
        requirement: "GeoRisk",
        capability: "DataGuard",
        sector: "Gobierno",
        user: {
            selfie: IMAGES.user.src,
            name: "Dr. Ernesto Soto",
            company: "Protección Civil Estatal",
            title: "La colaboración facilitada por PIVITMor nos ha permitido implementar una herramienta vital para la seguridad de la población.",
            comments:
                "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris ac justo quis velit faucibus sagittis sit amet sit amet augue. Nam nibh augue, hendrerit ac aliquam quis, elementum ac dolor. Nulla mi leo, condimentum et purus sed, pulvinar tempor ante. Mauris sed dui quis risus lobortis condimentum in ac dolor. Praesent felis orci, elementum et fringilla vitae, ultrices in risus. Proin id dignissim sapien. Duis malesuada pulvinar sapien, eget rutrum justo elementum id. Nulla consectetur eros lectus, a tincidunt mauris ornare ac. Nunc vel sem nisi.",
        },
        highlight: "Impacto: Reducción del 50% en pérdidas materiales",
    },
    {
        id: 6,
        title: "Plataforma de e-learning para capacitación laboral",
        description:
            "Una colaboración entre EduTech y SkillUp, esta plataforma ofrece cursos especializados para mejorar las habilidades de la fuerza laboral.",
        requirement: "EduTech",
        capability: "SkillUp",
        sector: "Academia",
        user: {
            selfie: IMAGES.user.src,
            name: "Lic. Patricia Ruiz",
            company: "Cámara de Comercio",
            title: "Gracias a PIVITMor, pudimos conectar con la academia para desarrollar",
            comments:
                "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Mauris ac justo quis velit faucibus sagittis sit amet sit amet augue. Nam nibh augue, hendrerit ac aliquam quis, elementum ac dolor. Nulla mi leo, condimentum et purus sed, pulvinar tempor ante. Mauris sed dui quis risus lobortis condimentum in ac dolor. Praesent felis orci, elementum et fringilla vitae, ultrices in risus. Proin id dignissim sapien. Duis malesuada pulvinar sapien, eget rutrum justo elementum id. Nulla consectetur eros lectus, a tincidunt mauris ornare ac. Nunc vel sem nisi.",
        },
        highlight: "Beneficio: más desarrollos academicos",
    },
];

export const faq = [
    {
        id: 1,
        question: "¿Qué es PIVITMor?",
        answer: "PIVITMor es una plataforma que conecta la oferta y la demanda tecnológica en Morelos, impulsando la innovación y el desarrollo económico.",
    },
    {
        id: 2,
        question: "¿Quiénes pueden usar PIVITMor?",
        answer: "Empresas, emprendedores, instituciones académicas, gobierno y sociedad civil que busquen soluciones tecnológicas o quieran ofrecerlas.",
    },
    {
        id: 3,
        question: "¿Cómo me registro en PIVITMor?",
        answer: "Puedes registrarte como demandante (si buscas tecnología) u ofertante (si la ofreces) a través de nuestro formulario en línea.",
    },
    {
        id: 4,
        question: "¿Tiene algún costo usar PIVITMor?",
        answer: "El uso básico de la plataforma es gratuito. Para servicios premium o especializados, consulta nuestras opciones de membresía.",
    },
];

export const typeUsers = [
    {
        icon: mdiSchoolOutline,
        title: "Para IES/CI",
        description:
            "Fortalece la vinculación de tu institución y acelera la transferencia tecnológica en el ecosistema de innovación de Morelos.",
        buttonText: "Solicita tu registro",
        color: "from-blue-500 to-blue-900",
        benefits: [
            "Mayor visibilidad de capacidades y servicios tecnológicos",
            "Vinculación directa con empresas y sectores productivos",
            "Impulso a proyectos de transferencia y colaboración tecnológica",
        ],
    },
    {
        icon: mdiDomain,
        title: "Para Empresa de Base tecnológica",
        description:
            "Impulsa el crecimiento de tu empresa mediante alianzas estratégicas con centros de investigación e innovación",
        buttonText: "Solicita el registro de tu empresa",
        color: "from-green-500 to-green-600",
        benefits: [
            "Acceso a capacidades y servicios tecnológicos especializados",
            "Colaboración directa con academia y expertos",
            "Fortalecimiento de procesos de innovación y desarrollo empresarial",
        ],
    },
    {
        icon: mdiTownHall,
        title: "Para Dependencias de Gobierno",
        description:
            "Fortalece la atención a las problemáticas públicas mediante la vinculación con actores científicos y tecnológicos del ecosistema de innovación.",
        buttonText: "Solicita el registro como dependencia",
        color: "from-purple-500 to-purple-600",
        benefits: [
            "Acceso a capacidades y servicios tecnológicos especializados",
            "Articulación con academia, centros de investigación y empresas",
            "Impulso a soluciones innovadoras para el desarrollo regional",
        ],
    },
    {
        icon: mdiHandshakeOutline,
        title: "Para Organizaciones de la Sociedad Civil (ONG)",
        description:
            "Potencia el impacto social de tus iniciativas mediante la vinculación con las capacidades científicas y tecnológicas del ecosistema de innovación.",
        buttonText: "Solicita el registro como ONG",
        color: "from-purple-500 to-purple-600",
        benefits: [
            "Acceso a capacidades y servicios tecnológicos aplicados al impacto social",
            "Colaboración con academia, centros de investigación y empresas",
            "Desarrollo de soluciones innovadoras para problemáticas sociales y ambientales",
        ],
    },
];

export const statisticsMap = [
    {
        title: "80+",
        description: "Instituciones de Educación Superior",
        src: ICONS.ies.src,
    },
    {
        title: "100+",
        description: "Centros de Investigación",
        src: ICONS.ci.src,
    },
    {
        title: "230+",
        description: "Industría/empresas",
        src: ICONS.industry.src,
    },
    {
        title: "1000+",
        description: "Investigadores/Académicos",
        src: ICONS.academic.src,
    },
    {
        title: "234+",
        description: "Empresas de base tecnológica",
        src: ICONS.techCompany.src,
    },
    {
        title: "80+",
        description: "Necesidades tecnológicas activas",
        src: ICONS.techDemand.src,
    },
    {
        title: "123+",
        description: "Ofertas tecnológicas activas",
        src: ICONS.techOffer.src,
    },
    {
        title: "200+",
        description: "Servicios tecnológicos",
        src: ICONS.techServices.src,
    },
    {
        title: "150+",
        description: "Proyectos en colaboración",
        src: ICONS.techCollaboration.src,
    },
];

export const economicSectors = [
    {
        name: "Aeroespacial",
        src: ICONS.aerospacePink.src,
    },
    {
        name: "Agua, agro y alimentos",
        src: ICONS.waterAndEarthPink.src,
    },
    {
        name: "Automotriz y electromovilidad",
        src: ICONS.automotivePink.src,
    },
    {
        name: "Bienes de consumo",
        src: ICONS.consumerGoodsPink.src,
    },
    {
        name: "Educación",
        src: ICONS.educationPink.src,
    },
    {
        name: "Eléctrico-electrónico y semiconductores",
        src: ICONS.electricElectronicPink.src,
    },
    {
        name: "Energía",
        src: ICONS.energyPink.src,
    },
    {
        name: "Inclusión y bienestar",
        src: ICONS.inclusionPink.src,
    },
    {
        name: "Minero-metalúrgico",
        src: ICONS.minerPink.src,
    },
    {
        name: "Salud",
        src: ICONS.healthPink.src,
    },
    {
        name: "Seguridad alimentaria",
        src: ICONS.securityPink.src,
    },
    {
        name: "Telecomunicaciones",
        src: ICONS.telecommunicationPink.src,
    },
    {
        name: "TI y economía digital",
        src: ICONS.informationTechnologyPink.src,
    },
    {
        name: "Turismo",
        src: ICONS.tourismPink.src,
    },
    {
        name: "Vivienda y hábitat",
        src: ICONS.housingPink.src,
    },
];

export const news = [
    {
        id: 1,
        title: `Impulsa Gobierno de Morelos emprendimiento infantil y juvenil con taller especializado.`,
        cover: "/img/temp/new-1.avif",
        date: "25 de agosto de 2025",
        bulletin: 12321,
        description: `A través de “Mi Primer Emprendimiento Jr”, se brindaron las herramientas e inspiración para transformar las ideas en proyectos con impacto real para las comunidades`,
    },
    {
        id: 2,
        title: `Lleva Gobierno de Morelos ciencia a las comunidades con miniferia Cienciaventura: experiencia de verano, en Zacualpan de Amilpas`,
        cover: "/img/temp/new-2.avif",
        date: "25 de agosto de 2025",
        bulletin: 12320,
        description: `El evento reunió a más de 100 niñas, niños, jóvenes y sus familias, en un espacio seguro y motivador`,
    },
    {
        id: 3,
        title: `Finaliza Curso de Verano Científico para infancias en el Parque Barranca de Chapultepec.`,
        cover: "/img/temp/new-3.avif",
        date: "19 de agosto de 2025",
        bulletin: 12319,
        description: `Las actividades están dirigidas a niñas y niños de seis a once años de edad, con un cupo limitado a 100 participantes`,
    },
    {
        id: 4,
        title: `Lleva Gobierno de Morelos la ciencia a las comunidades con miniferia cienciaventura: experiencia de verano`,
        cover: "/img/temp/new-4.avif",
        date: "22 de agosto de 2025",
        bulletin: 12318,
        description: `Más de 100 participantes entre niñas, niños, juventudes y familias asistieron a la primera edición en Tilzapotla, Puente de Ixtla`,
    },
    {
        id: 5,
        title: `Finaliza con éxito curso de verano y miniferias científicas del centro morelense de comunicación de la ciencia`,
        cover: "/img/temp/new-5.avif",
        date: "22 de agosto de 2025",
        bulletin: 12317,
        description: `Participaron 100 niñas y niños de entre seis y 11 años de edad, en una semana de actividades científicas y ambientales`,
    },
    {
        id: 6,
        title: `Inicia Gobierno de Morelos viaje de la segunda etapa del Campamento Aeroespacial “Misión Código Europa 2025.”`,
        cover: "/img/temp/new-6.avif",
        date: "21 de agosto de 2025",
        bulletin: 12316,
        description: `El campamento es liderado por Katya Echazarreta González, primera mujer mexicana en viajar al espacio`,
    },
];
