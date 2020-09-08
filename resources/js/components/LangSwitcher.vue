<template>
  <div class="locale-changer">
    <div  class="header_all_right_lang_select" :class="{active: isActive}">
      <div  class="selected_lang_1_cover" @click="openLangMenu()" >
        <a  class="selected_lang_1"   ><img width="30" :src="'/img/'+$i18n.locale+'.png'"></a>
        <span  class="selected_lang_1_cover_span">
          <i class="pe-7s-angle-down"></i>
        </span>
      </div>
      <div  class="unselected_lang_2">
        <a v-for="(lang, i) in langs" :key="`Lang${i}`" class="selected_lang_1" @click="switchLocale(lang)"><img width="30" :src="'/img/'+lang+'.png'"></a>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  data() {
    return { 
      langs: ["ru", "uz"],
      isActive: false, 
    };
  },
  methods: {
    switchLocale(lang) {
      this.$i18n.locale = lang
      localStorage.setItem("locale", lang);
      this.isActive = !this.isActive
    },
    openLangMenu(){
      this.isActive = !this.isActive
    }
  }
};
</script>
<style  scoped>
.header_all_right_lang_select {
  margin-left: 20px;
  padding: 5px 15px 5px 15px;
  border: none;
  background-color: transparent;
  border-left: 1px solid #cfdee6;
  color: #fff;
  font-size: 14px;
  position: relative;
}
.selected_lang_1_cover {
  padding-right: 24px;
  width: 100%;
  position: relative;
  font-size: 14px;
  color: #fff;
  cursor: pointer;
}
.selected_lang_1 {
  font-size: 16px;
  color: #7a8f99;
  cursor: pointer;
      text-align: center;
display: block;
}
.selected_lang_1_cover_span {
    position: absolute;
    right: -10px;
    top: -4px;
}
.selected_lang_1_cover_span>i {
-webkit-transition-duration: .2s;
  transition-duration: .2s;
  font-size:40px;
}
.unselected_lang_2{
  background-color: #fff;
  position: absolute;
  left: 0;
  top: 100%;
  right: 0;
  width: 100%;
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  -webkit-box-orient: vertical;
  -webkit-box-direction: normal;
  -ms-flex-direction: column;
  flex-direction: column;
  border: 1px solid #cfdee5;
  text-align: center;
  border-radius: 10px;
  opacity: 0;
  visibility: hidden;
  -webkit-transition-duration: .3s;
  transition-duration: .3s;
  overflow: hidden;
}

.unselected_lang_2>.selected_lang_1 {
padding: 10px 5px;
border-bottom: 1px solid #cfdee5;
color: #18aaf2;
}
.unselected_lang_2>.selected_lang_1:last-child {
border-bottom: none;
}
.header_all_right_lang_select.active .selected_lang_1_cover_span>i {
-webkit-transform: rotate(-180deg);
transform: rotate(-180deg);
}
.header_all_right_lang_select.active .unselected_lang_2{
  opacity: 1;
  visibility: visible;
}
</style>