/**
 * патч для Marionette для потдержки шаблонизатора Twig
 * Created by bender on 18.04.16.
 */


Backbone.Marionette.TemplateCache.prototype.loadTemplate = function(templateId) {
    return templateId;
};

Backbone.Marionette.TemplateCache.prototype.compileTemplate = function(rawTemplate) {
    if (twig({ ref: rawTemplate })){
        return twig({ ref: rawTemplate })
    } else {
        return twig({
            id: rawTemplate,
            href: rawTemplate,
            async: false
        });
    }
};

Backbone.Marionette.Renderer.render = function(template,data) {
    return Marionette.TemplateCache.get(template).render(data);
};