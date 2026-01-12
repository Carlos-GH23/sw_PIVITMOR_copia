import capability from "./domains/capability";
import requirement from "./domains/requirement";
import technologyService from "./domains/technologyService";
import facility from "./domains/facility";
import equipment from "./domains/equipment";
import institutionCertification from "./domains/institutionCertification";
import academic from "./domains/academic";
import researchLine from "./domains/researchLine";
import academicBody from "./domains/academicBody";
import conference from "./domains/conference";
import jobOffer from "./domains/jobOffer";
import academicOffering from "./domains/academicOffering";
import research_center from "./domains/institution";
import higher_education from "./domains/institution";
import company from "./domains/company";
import governmentAgency from "./domains/governmentAgency";
import nonProfit from "./domains/nonProfit";

export default {
    capability,
    requirement,
    technology_service: technologyService,
    facility,
    equipment,
    institution_certification: institutionCertification,
    academic,
    research_line: researchLine,
    academic_body: academicBody,
    conference,
    job_offer: jobOffer,
    academic_offering: academicOffering,
    research_center,
    higher_education,
    company,
    government_agency: governmentAgency,
    non_profit: nonProfit,
};
