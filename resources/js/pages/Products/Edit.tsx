import { useState } from 'react';
import { useForm } from '@inertiajs/react';
import { Alert, AlertDescription, AlertTitle } from '@/components/ui/alert';
import { Button } from '@/components/ui/button';
import { Input } from '@/components/ui/input';
import { Label } from '@/components/ui/label';
import { Textarea } from '@/components/ui/textarea';
import AppLayout from '@/layouts/app-layout';
import { CircleAlert } from 'lucide-react';
import { Head } from '@inertiajs/react';
import { route } from 'ziggy-js';

interface Product {
  id: number;
  name: string;
  description: string;
  price: number | string;
  image?: string | null; // existing image path
}

interface Props {
  product: Product;
}

export default function Edit({ product }: Props) {
  const form = useForm({
    name: product.name,
    price: product.price,
    description: product.description,
    image: null as File | null,
  });

  // Preview for existing or new image
  const [preview, setPreview] = useState<string | null>(
    product.image ? `/storage/${product.image}` : null
  );

  const handleFileChange = (e: React.ChangeEvent<HTMLInputElement>) => {
    if (e.target.files && e.target.files.length > 0) {
      const file = e.target.files[0];
      form.setData('image', file);
      setPreview(URL.createObjectURL(file)); // show preview
    }
  };

  const handleUpdate = (e: React.FormEvent) => {
    e.preventDefault();
    form.post(`/products/${product.id}`, { forceFormData: true });
  };

  return (
    <AppLayout
      breadcrumbs={[{ title: 'Edit Product', href: `/products/${product.id}/edit` }]}
    >
      <Head title="Edit Product" />
      <div className="w-8/12 p-4">
        <form onSubmit={handleUpdate} className="space-y-4">
          {/* Display validation errors */}
          {Object.keys(form.errors).length > 0 && (
            <Alert>
              <CircleAlert className="h-4 w-4" />
              <AlertTitle>Errors!</AlertTitle>
              <AlertDescription>
                <ul>
                  {Object.entries(form.errors).map(([key, message]) => (
                    <li key={key}>{message as string}</li>
                  ))}
                </ul>
              </AlertDescription>
            </Alert>
          )}

          <div className="gap-1.5">
            <Label>Name</Label>
            <Input
              placeholder="Product Name"
              value={form.data.name}
              onChange={(e) => form.setData('name', e.target.value)}
            />
          </div>

          <div className="gap-1.5">
            <Label>Price</Label>
            <Input
              type="number"
              placeholder="Price"
              value={form.data.price}
              onChange={(e) => form.setData('price', e.target.value)}
            />
          </div>

          <div className="gap-1.5">
            <Label>Description</Label>
            <Textarea
              placeholder="Description"
              value={form.data.description}
              onChange={(e) => form.setData('description', e.target.value)}
            />
          </div>

          <div className="gap-1.5">
            <Label>Upload Image</Label>
            <Input type="file" accept="image/*" onChange={handleFileChange} />
          </div>

          {/* Preview image */}
          {preview && (
            <div className="w-32 h-32 mt-2">
              <img
                src={preview}
                alt="Preview"
                className="w-full h-full object-cover rounded"
              />
            </div>
          )}

          <Button type="submit" disabled={form.processing}>
            Update Product
          </Button>
        </form>
      </div>
    </AppLayout>
  );
}
