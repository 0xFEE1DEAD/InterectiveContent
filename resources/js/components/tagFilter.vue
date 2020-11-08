<template>
  <div>
    <b-form-group style="margin: 10px 40px" label="Поиск по тегам">
      <b-form-tags v-model="value" size="lg" add-on-change no-outer-focus class="mb-2">
        <template v-slot="{ tags, inputAttrs, inputHandlers, disabled, removeTag }">
          <ul v-if="tags.length > 0" class="list-inline d-inline-block mb-2">
            <li v-for="tag in tags" :key="tag" class="list-inline-item">
              <b-form-tag
                @remove="removeTag(tag)"
                :title="tag"
                :disabled="disabled"
                variant="info"
              >{{ tag }}</b-form-tag>
            </li>
          </ul>
          <b-input-group>
            <b-form-select
                v-bind="inputAttrs"
                v-on="inputHandlers"
                :disabled="disabled || availableOptions.length === 0"
                :options="availableOptions"
            >
                <template #first>
                <option disabled value="">Выбирите тэг</option>
                </template>
            </b-form-select>
            <b-input-group-append>
                <b-button variant="info" @click="filterAction">Применить</b-button>
            </b-input-group-append>
          </b-input-group>
        </template>
      </b-form-tags>
    </b-form-group>
  </div>
</template>

<script>
import { bus } from '../app'

  export default {
    data() {
      return {
        options: [],
        value: [],
        tags: []
      }
    },
    mounted() {
        window.axios.get('/api/tags').then((v)=>{
            this.tags = v.data.tags
            for(let i = 0; i < this.tags.length; ++i) {
                this.options.push(this.tags[i].name);
            }
        })
    },
    computed: {
      availableOptions() {
        return this.options.filter(opt => this.value.indexOf(opt) === -1)
      }
    },
    methods: {
        filterAction() {
            var val = []
            for(let i = 0; i < this.value.length; ++i) {
                for(let j = 0; j < this.tags.length; ++j) {
                    if(this.tags[j].name == this.value[i]) {
                        val.push(this.tags[j].id);
                    }
                }
            }
            bus.$emit('change_tags', val);
            bus.$emit('posts_update');
        }
    }
  }
</script>