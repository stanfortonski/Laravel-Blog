export default {
    language: 'en',
    toolbar: ['heading', '|', 'bold', 'italic', '|', 'bulletedList', 'numberedList', 'insertTable', '|', 'blockQuote', 'link'],
    heading: {
        options: [
            { model: 'paragraph', title: 'Paragraph', class: 'ck-heading_paragraph'},
            { model: 'heading2', view: 'h2', title: 'Heading 1', class: 'ck-heading_heading2' },
            { model: 'heading3', view: 'h3', title: 'Heading 2', class: 'ck-heading_heading3' },
            { model: 'heading4', view: 'h4', title: 'Heading 3', class: 'ck-heading_heading4' },
        ]
    }
}
