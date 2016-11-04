using Newtonsoft.Json.Linq;
using System;
using System.Collections.Generic;
using System.ComponentModel;
using System.Data;
using System.Drawing;
using System.Linq;
using System.Text;
using System.Threading.Tasks;
using System.Windows.Forms;

namespace AiderApp.Views
{
    public partial class ArticleView : Form
    {
        Form parent;

        public ArticleView(Form parent, ListView lv, int i)
        {
            this.parent = parent;
            InitializeComponent();
            //string ARTICLE_ID = ?
            //string url = "http://37.97.195.239/bm01/api.php/article/" + ARTICLE_ID;
            updateOutput(lv, i);

            this.Visible = true;
            this.TopMost = true;
        }

        public void updateOutput(ListView lv, int i)
        {
            label1.Text = "test1";
            label2.Text = "test2";
            textBox1.Text = "test3";
            //label1.Text = lv.GetItemAt(0, i).ToString();
            //label2.Text = lv.GetItemAt(1, i).ToString();
            //textBox1.Text = lv.GetItemAt(2, i).ToString();
        }

        private void button1_Click(object sender, EventArgs e)
        {
            Close();
        }
    }
}
