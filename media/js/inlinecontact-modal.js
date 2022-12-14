/**
 * @copyright  Alexander Niklaus
 * @license    GNU General Public License version 2 or later; see LICENSE.txt
 */
(() => {

    window.inlineContactSelect = (id, type) => {

        if (!Joomla.getOptions('xtd-inlinecontact')) {
            // Something went wrong
            window.parent.Joomla.Modal.getCurrent().close();
            return false;
        }

        const {
            editor
        } = Joomla.getOptions('xtd-inlinecontact');

        const templateInput = document.getElementById('ictemplate');
        const icTemplate = parseInt(templateInput.value) || 0;

        let tag;

        if (type === 'contact') {
            if (icTemplate !== 0) {
                tag = `{inlinecontact ${id} ${icTemplate}}`;
            } else {
                tag = `{inlinecontact ${id}} {/inlinecontact}`;
            }
        } else {

            if (icTemplate === 0) {
                templateInput.classList.add('is-invalid');
                return false;
            }

            const icSort = parseInt(document.getElementById('icsort').value) || 0;
            const icFeatured = parseInt(document.getElementById('icfeatured').value) || 0;

            const tagFeatured = icFeatured !== 0 ? ' ' + icFeatured : ''
            const tagSort = icSort !== 0 || icFeatured !== 0  ? ' ' + icSort : ''


            tag = `{inlinecontactlist ${id} ${icTemplate}${tagSort}${tagFeatured}}`;
        }


        window.parent.Joomla.editors.instances[editor].replaceSelection(tag);
        if (window.parent.Joomla.Modal) {
            window.parent.Joomla.Modal.getCurrent().close();
        }
        return true;
    };

    document.addEventListener('DOMContentLoaded', () => {
        // Get the elements
        const elements = document.querySelectorAll('.select-link');

        for (let i = 0, l = elements.length; l > i; i += 1) {
            // Listen for click event
            elements[i].addEventListener('click', event => {
                event.preventDefault();
                const functionName = event.target.getAttribute('data-function');

                window[functionName](event.target.getAttribute('data-id'), event.target.getAttribute('data-type'));
            });
        }
    });
})();
